<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreatePageController extends AbstractController
{
    #[Route('/create/page', name: 'app_create_page')]
    public function index(): Response
    {
        return $this->render('create_page/index.html.twig', [
            'controller_name' => 'CreatePageController',
        ]);
    }
}
