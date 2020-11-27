<?php


namespace App\Controller;


use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
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

    /**
     * @Route("/category/show/{id}", name="category_show")
     */
    // en parametre de la méthode, je récupère la valeur de la wildcard id
    // et je demande en plus à symfony d'instancier pour moi
    // la classe ArticleRepository dans une variable $articleRepository
    // (autowire)

    public function categorieShow($id, CategoryRepository $categoriesRepository)
    {
        // J'utilise l'ArticleRepository avec la méthode find pour faire
        // une requête SQL SELECT en BDD et retrouver l'article dont l'id correspond à l'id passé en URL
        $categories = $categoriesRepository->find($id);

        // Les afficher dans un fichier twig
        return $this->render('category.html.twig', [
            'category' => $categories
        ]);
    }
}