<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SuccessPayController extends AbstractController
{
    #[Route('/success/pay', name: 'app_success_pay')]
    public function index(): Response
    {
        return $this->render('success_pay/index.html.twig', [
            'controller_name' => 'SuccessPayController',
        ]);
    }
}
