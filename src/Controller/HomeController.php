<?php

namespace App\Controller;

use App\Entity\Page;
use App\Entity\Site;
use App\Form\CreateSiteType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PageRepository;
use App\Repository\SiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $pageRepository;
    private $siteRepository;

    public function __construct(
        PageRepository $pageRepository,
        SiteRepository $siteRepository,
        EntityManagerInterface $entityManager
    )
    {
        $this->pageRepository = $pageRepository;
        $this->siteRepository = $siteRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_home')]
    public function index(Request $request): Response
    {
        $pages = $this->pageRepository->findAll();
        $site = $this->siteRepository->findAll();

        if (empty($site)) {
            $site = new Site(); // Créer une nouvelle instance de Site
            $form = $this->createForm(CreateSiteType::class, $site);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Gérer l'upload de l'image ici si nécessaire
                $file = $form['Logo']->getData();
                if ($file) {
                    $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                    $file->move(
                        $this->getParameter('your_directory'), // Répertoire cible
                        $fileName
                    );
                    $site->setLogo($fileName);
                }
                // Enregistrer l'entité
                $this->entityManager->persist($site);
                $this->entityManager->flush();
                // Rediriger ou faire autre chose après le succès
            }
            return $this->render('home/newSite.html.twig', [
                'site' => $site,
                'form' => $form->createView(),
            ]);
        } else {
            // Table "site" n'est pas vide
            return $this->render('home/index.html.twig', [
                'pages' => $pages,
                'site' => $site,
            ]);
        }
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
