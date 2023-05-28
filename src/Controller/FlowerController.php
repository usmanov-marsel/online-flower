<?php

namespace App\Controller;

use App\Repository\FlowerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FlowerController extends AbstractController
{
    #[Route('/flower', name: 'app_flower')]
    public function index(FlowerRepository $flowerRepository): Response
    {
        return $this->render('flower/index.html.twig', [
            'flowers' => $flowerRepository->findAll()
        ]);
    }
}
