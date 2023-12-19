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

            $imageFile = $form['Image']->getData();

            // Vérifier s'il y a un fichier uploadé
            if ($imageFile) {
            // Générer un nom de fichier unique
            $newFilename = uniqid().'.'.$imageFile->guessExtension();

            // Déplacer le fichier vers le dossier 'photo' (à ajuster selon votre configuration)
            $imageFile->move(
                $this->getParameter('kernel.project_dir') . '/public/photo/',
                $newFilename
            );

            // Mettre à jour le champ 'Image' de l'entité avec le nom du fichier
            $page->setImage($newFilename);
        }


            $this->entityManagerInterface->persist($page);

            $this->entityManagerInterface->flush();

            return $this->redirectToRoute('app_home');

        }

        return $this->render('create_page/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/edit/page/{id}', name: 'app_edit_page')]
    public function editer(Request $request,$id)
    {
        $page =$this->pageRepository->find($id); // Créez une nouvelle instance de Page ici, si nécessaire
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form['Image']->getData();

            // Vérifier s'il y a un fichier uploadé
            if ($imageFile) {
            // Générer un nom de fichier unique
            $newFilename = uniqid().'.'.$imageFile->guessExtension();

            // Déplacer le fichier vers le dossier 'photo' (à ajuster selon votre configuration)
            $imageFile->move(
                $this->getParameter('kernel.project_dir') . '/public/photo/',
                $newFilename
            );

            // Mettre à jour le champ 'Image' de l'entité avec le nom du fichier
            $page->setImage($newFilename);
        }

            $this->entityManagerInterface->persist($page);

            $this->entityManagerInterface->flush();

            return $this->redirectToRoute('app_home');

        }

        return $this->render('create_page/edit.html.twig', [
            'form' => $form->createView(),
            'page'=>$page
        ]);
    }
}
