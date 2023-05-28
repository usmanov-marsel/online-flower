<?php

namespace App\Controller;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ApiLoginController extends AbstractController
{
    public function __construct(private readonly ClientRepository $clientRepository)
    {
    }

    #[Route('/api/login', name: 'app_api_login')]
    public function login(Request $request, JWTTokenManagerInterface $JWTManager, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $payload = json_decode($request->getContent(), false);
        $email = $payload->email;
        $password = $payload->password;
        $phone = $payload->phone;
        $name = $payload->name;
        if ($this->clientRepository->findOneBy(['email' => $email]) !== null) {
            throw new \RuntimeException("user already exist");
        }
        $client = (new Client())->setEmail($email)->setRoles(['ROLE_USER'])->setName($name)->setPhone($phone);
        $hashPassword = $passwordHasher->hashPassword($client, $password);
        $client->setPassword($hashPassword);
        $this->clientRepository->save($client, true);
        $token = $JWTManager->create($client);
        return $this->json([
            'token' => $token,
        ]);
    }
}
