<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // La ligne de commande bin/console make:form va générer automatiquement ce fichier.
        // C'est un gabarit de formulaire pour l'Entité Category que j'ai spécifié en ligne de commande
        $builder
            ->add('title')
            ->add('color')
            ->add('publicationDate')
            ->add('creationDate')
            ->add('isPublished')
            ->add('Envoyer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
