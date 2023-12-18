<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\PageType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Page;
use App\Repository\PageRepository;
use Doctrine\ORM\EntityManagerInterface;

class CreatePageController extends AbstractController
{
    public function __construct(private PageRepository $pageRepository,private EntityManagerInterface $entityManagerInterface)
    {

    }

    #[Route('/create/page', name: 'app_create_page')]
    public function index(Request $request)
    {
        $page = new Page(); // Créez une nouvelle instance de Page ici, si nécessaire
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManagerInterface->persist($page);

            $this->entityManagerInterface->flush();

            return $this->redirectToRoute('app_home');

        }

        return $this->render('create_page/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
