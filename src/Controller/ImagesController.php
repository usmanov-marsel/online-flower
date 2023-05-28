<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImagesController extends AbstractController
{
    #[Route('/images/{filename}', name: 'app_images')]
    public function index(string $filename): Response
    {
        $file = '/home/marsel/online-flower/public/uploads/images/' . $filename;
        return new BinaryFileResponse($file);
    }
}
