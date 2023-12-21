<?php

namespace App\Controller;

use App\Entity\Page;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PageRepository;
use App\Repository\SiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct(
        PageRepository $pageRepository,
        SiteRepository $siteRepository
    )
    {
        $this->pageRepository = $pageRepository;
        $this->siteRepository = $siteRepository;
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $pages = $this->pageRepository->findAll();
        $site = $this->siteRepository->findAll();
        dump($pages);
        return $this->render('home/index.html.twig', [
            'pages' => $pages,
            'site' => $site,
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
