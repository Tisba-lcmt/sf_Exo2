<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // La ligne de commande bin/console make:form va générer automatiquement ce fichier.
        // C'est un gabarit de formulaire pour l'Entité Article que j'ai spécifié en ligne de commande
        $builder
            ->add('title')
            ->add('content')
            ->add('image')
            ->add('publicationDate', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('creationDate', DateType::class, [
                'widget' => 'single_text'
            ])
            // Dans mon gabarit de formulaire ArticleType, je créé un input category
            // relié à ma propriété category dans l'entité Article.
            // Vu que c'est une relation vers une autre entité (une autre table) je lui passe
            // en type "EntityType" pour décrire que c'est de type Entité
            ->add('category', EntityType::class, [
                // Je précise que c'est bien dans l'Entity Category que je veux affiche
                // mon input et donc je pourrais afficher toutes les catégories sous forme
                // de liste déroulante.
                'class' => Category::class,
                // Dans la liste déroulante, je choisirai la propriété à afficher pour
                // chacune des catégories (il faut qu'elle permette à l'utilisateur
                // d'identifer et de choisir une catégorie).
                // ici c'est le titre qui est obligatoire dans la saisie et qui identifie
                // la catégorie.
                'choice_label' => 'title'
            ])
            ->add('isPublished')
            ->add('Envoyer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
