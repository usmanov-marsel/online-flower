<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ApiResetPasswordController extends AbstractController
{
    public function __construct(private readonly ClientRepository $clientRepository)
    {
    }

    #[Route('/api/reset', name: 'app_api_reset')]
    public function reset(Request $request, UserPasswordHasherInterface $passwordHasher, MailerInterface $mailer): JsonResponse
    {
        $payload = json_decode($request->getContent(), false);
        $email = $payload->email;
        $client = $this->clientRepository->findOneBy(['email' => $email]);
        if ($client == null) {
            throw new \RuntimeException("email free");
        }
        $link = $passwordHasher->hashPassword($client, $email . '1234');
        $client->setLink($link);
        $this->clientRepository->save($client, true);
        $email = (new Email())
            ->from('online-flower@domain.com')
            ->to($email)
            ->subject('Восстановление пароля')
            ->html("<p>Для восстановления пароля нажмите на ссылку:</p>
            <a href='https://localhost:3000/api/check?link=$link'>Восстановить</a>");

        $mailer->send($email);
        return $this->json([
            'message' => 'Check email for reset password',
        ]);
    }

    #[Route('/api/check', name: 'app_api_check')]
    public function check(Request $request): JsonResponse
    {
        $link = $request->query->get('link', '');
        $client = $this->clientRepository->findOneBy(['link' => $link]);
        if ($client == null) {
            throw new \RuntimeException("wrong link");
        }
        $client->setVerifyEmail(true);
        $this->clientRepository->save($client, true);
        return $this->json([
            'message' => 'success',
        ]);
    }

    #[Route('/api/new-password', name: 'app_api_check')]
    public function createNewPassword(Request $request, JWTTokenManagerInterface $JWTManager, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $payload = json_decode($request->getContent(), false);
        $email = $payload->email;
        $password = $payload->password;
        $client = $this->clientRepository->findOneBy(['email' => $email]);
        if ($client == null || $client->isVerifyEmail()) {
            throw new \RuntimeException("wrong email or not confirmed");
        }
        $hashPassword = $passwordHasher->hashPassword($client, $password);
        $client->setPassword($hashPassword);
        $this->clientRepository->save($client, true);
        $token = $JWTManager->create($client);
        return $this->json([
            'token' => $token,
        ]);
    }
}
