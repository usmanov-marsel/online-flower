<?php

namespace App\MessageHandler;

use App\Message\OrderMessage;
use App\Repository\OrderRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use YooKassa\Client;

#[AsMessageHandler]
class OrderMessageHandler
{
  public function __construct(
    private OrderRepository $orderRepository
  ) {
  }

  public function __invoke(OrderMessage $message)
  {
    $idOrder = $message->getIdOrder();
    $order = $this->orderRepository->find($idOrder);
    if ($order->getStatus() != 'Не оплачено') {
      return;
    }
    $client = new Client();
    $client->setAuth('317647', 'test_AZbJIIbfQCqk7oP9NdYVlbkbvJIP0e0IxIYv-x1OdEQ');
    $payment = $client->getPaymentInfo($order->getId());
    if ($payment->status == 'succeeded') {
      $order->setStatus('Оплачено');
      $this->orderRepository->save($order, true);
      return;
    }
    throw new \RuntimeException('Order no pay!');
  }
}
