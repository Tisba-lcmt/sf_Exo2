<?php


namespace App\Controller;


use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoriesController extends AbstractController
{
    /**
     * @Route("/categories", name="categories_list")
     */

    public function categoriesList(CategoryRepository $categoriesRepository)
    {
        // Grâce à l'injection de dépendance de Symfony je peux mettre la classe
        // CategoryRepository généréé automatiquement par SF en paramètre de la méthode
        // que j'instancie dans une variable afin de récupérer toutes les catégories
        // de ma table Category en faisant des requêtes SELECT en BDD.
        // La méthode findAll() de la classe CategoryRepository me permet
        // de récupérer tous les éléments de la table Category.

        $categories = $categoriesRepository->findAll();

        return $this->render('categories.html.twig', [
            'categories' => $categories
        ]);
    }
    
}