<?php

namespace App\Controller;

use App\Entity\Bouquet;
use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\FlowerItem;
use App\Entity\Order;
use App\Form\OrderType;
use App\Message\OrderMessage;
use App\Repository\CartItemRepository;
use App\Repository\CartRepository;
use App\Repository\ClientRepository;
use App\Repository\DecorationRepository;
use App\Repository\FlowerItemRepository;
use App\Repository\FlowerRepository;
use App\Repository\OrderRepository;
use App\Repository\PackageRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use YooKassa\Client;

class OrderController extends AbstractController
{
    public function __construct(
        private readonly FlowerRepository $flowerRepository,
        private readonly PackageRepository $packageRepository,
        private readonly DecorationRepository $decorationRepository,
        private readonly OrderRepository $orderRepository,
        private readonly FlowerItemRepository $flowerItemRepository,
        private readonly CartRepository $cartRepository,
        private readonly ClientRepository $clientRepository,
        private readonly CartItemRepository $CartItemRepository,
        private readonly MessageBusInterface $bus,
        private readonly JWTTokenManagerInterface $jwtManager,
        private readonly TokenStorageInterface $tokenStorageInterface
    ) {
    }
    #[Route('/api/pay-form', name: 'app_pay_form')]
    public function index(Request $request, LoggerInterface $logger): Response
    {
        $decodedToken = $this->jwtManager->decode($this->tokenStorageInterface->getToken());
        $email = $decodedToken['email'];
        $user = $this->clientRepository->findOneBy(['email' => $email]);
        $cart = $user->getCarts()->last();
        $logger->info($cart);
        $order = new Order();
        $order->setStatus('Не оплачено');
        $order->setTotalPrice($cart->getTotalPrice());
        $order->setCart($cart);
        $order->setClient($user);
        $order->setId('1234');
        $orderForm = $this->createForm(OrderType::class, $order);
        $orderForm->handleRequest($request);
        if ($orderForm->isSubmitted()) {
            $client = new Client();
            $client->setAuth('317647', 'test_AZbJIIbfQCqk7oP9NdYVlbkbvJIP0e0IxIYv-x1OdEQ');
            $idempotenceKey = uniqid('', true);
            $response = $client->createPayment(
                array(
                    'amount' => array(
                        'value' => $order->getTotalPrice() / 100,
                        'currency' => 'RUB',
                    ),
                    'payment_method_data' => array(
                        'type' => 'bank_card',
                    ),
                    'confirmation' => array(
                        'type' => 'redirect',
                        'return_url' => 'https://localhost:3000/',
                    ),
                    'description' => 'Заказ №72',
                ),
                $idempotenceKey
            );
            $order->setId($response->id);
            $this->orderRepository->save($order, true);
            $this->bus->dispatch(new OrderMessage($order->getId()));
            $confirmationUrl = $response->getConfirmation()->getConfirmationUrl();
            return $this->redirect($confirmationUrl);
        }
        return $this->render('order/index.html.twig', [
            'controller_name' => 'OrderController',
            'email' => $email,
            'order_form' => $orderForm,
        ]);
    }
    #[Route('/api/cart', name: 'app_savecart')]
    public function cart(Request $request): Response
    {
        $decodedToken = $this->jwtManager->decode($this->tokenStorageInterface->getToken());
        $email = $decodedToken['email'];
        $user = $this->clientRepository->findOneBy(['email' => $email]);
        $payload = json_decode($request->getContent(), false);
        $cartItem = new CartItem();
        $cart = new Cart();
        $totalPrice = 0;
        $bouquets = $payload->bouquets;
        foreach ($bouquets as $bouquet) {
            $priceBouquet = 0;
            $bouquetObj = new Bouquet();
            $bouquetObj->setName('Букет №' . $bouquet->id);
            $flowers = $bouquet->flowers;
            foreach ($flowers as $flower) {
                $flowerObj = $this->flowerRepository->find($flower->id);
                $count = $flower->count;
                $flowerItem = new FlowerItem();
                $flowerItem->setFlower($flowerObj)->setCount($count);
                $bouquetObj->addFlowerItem($flowerItem);
                $priceBouquet += $count * $flowerObj->getPrice();
            }
            $packageObj = $this->packageRepository->find($bouquet->package->id);
            $decorationObj = $this->decorationRepository->find($bouquet->decoration->id);
            $priceBouquet += $packageObj->getPrice();
            $priceBouquet += $decorationObj->getPrice();
            $bouquetObj->setPackage($packageObj)->setDecoration($decorationObj)->setTotalPrice($priceBouquet);
            $totalPrice += $priceBouquet * $bouquet->count;
            $cartItem->setBouquet($bouquetObj)->setCount($bouquet->count);
            $cart->addCartItem($cartItem);
        }
        $cart->setTotalPrice($totalPrice);
        $user->addCart($cart);
        $this->cartRepository->save($cart, true);
        $this->clientRepository->save($user, true);
        return new JsonResponse(['message' => 'ok']);
    }
}
