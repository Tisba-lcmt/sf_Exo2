<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
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
            ->add('publicationDate')
            ->add('creationDate')
            ->add('isPublished')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}