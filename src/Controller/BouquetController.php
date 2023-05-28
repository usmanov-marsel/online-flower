<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BouquetController extends AbstractController
{
    #[Route('/bouquet', name: 'app_bouquet')]
    public function index(): Response
    {
        return $this->render('bouquet/index.html.twig', [
            'controller_name' => 'BouquetController',
        ]);
    }
}
