<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/contact', name:'app_contact')]
    public function contact()
    {
        return $this->render('Components/contact.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/about', name:'app_about')]
    public function about()
    {
        return $this->render('Components/about.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
