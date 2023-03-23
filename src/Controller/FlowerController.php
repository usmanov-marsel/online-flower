<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FlowerController extends AbstractController
{
    #[Route('/flower', name: 'app_flower')]
    public function index(): Response
    {
        return $this->render('flower/index.html.twig', [
            'controller_name' => 'FlowerController',
        ]);
    }
}
