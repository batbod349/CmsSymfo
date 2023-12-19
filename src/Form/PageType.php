<?php

namespace App\Form;

use App\Entity\Page;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Site;


class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $imagePath = $options['image_path'] ?? null;

        $builder
            ->add('Titre', TextType::class) // Champ pour le titre
            ->add('Contenu', TextareaType::class, [
                'attr' => [
                    'class' => 'tinymce',
                ],
            ])
            ->add('Image', FileType::class, [ // Utilisez FileType::class pour le champ de téléchargement de fichier
                'required' => false,
                'data' => $imagePath, // Utilisez le chemin de l'image pour pré-remplir le champ
                'mapped' => false,
            ]); // Indiquez que ce champ n'est pas mappé à l'entité
            // ->add('site', EntityType::class, [
            //     'class' => Site::class,
            //     'choice_label' => 'titre', // Remplacez 'nom' par la propriété du Site à afficher
            //     'placeholder' => 'Sélectionnez un site', // Ajoutez un placeholder si nécessaire
            // ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Page::class,
        ]);
    }
}