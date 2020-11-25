<?php


namespace App\Controller;


use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
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
     * @Route("/categorie/{id}", name="categorie_show")
     */
    public function categorieShow($id, CategoryRepository $categoriesRepository)
    {
        $categories = $categoriesRepository->find($id);

        // en parametre de la méthode, je récupère la valeur de la wildcard id
        // et je demande en plus à symfony d'instancier pour moi
        // la classe ArticleRepository dans une variable $articleRepository
        // (autowire)
        return $this->render('category.html.twig', [
            'category' => $categories
        ]);
    }

    /**
     * @Route("/category/static-insert", name="category_static_insert")
     */

    // Je demande à Symfony d'instancier pour moi la classe EntityManager (EntityManagerInterface)
    // dans la variable $entityManager.
    // Cette classe permet de faire les requêtes INSERT, UPDATE et DELETE.

    public function insertStaticArticle(EntityManagerInterface $entityManager)
    {
        // J'instancie ma classe Entité Article (équivalent de ma table en SQL)
        // pour pouvoir définir les valeurs de ses propriétés (et donc créer un nouvel enregistrement
        // dans la table article en BDD <=> INSERT INTO article() VALUES(); )
        $category = new Category();

        $category->setTitle("« Le retour à la normale ne sera pas pour demain » : Emmanuel Macron annonce un allégement du confinement en trois étapes");
        $category->setColor("#E3ED28");
        $category->setPublicationDate(new \DateTime());
        $category->setCreationDate(new \DateTime());
        $category->setIsPublished(true);

        // Je "pré-sauvegarde" mes modifications avec à la méthode
        // persist de l'EntityManager (comme un commit dans Git)

        //$entityManager->persist($category);

        // J'insère en BDD mes données "pré-sauvegardées" par la méthode persist en utilisant
        // à la méthode flush de l'EntityManager

        //$entityManager->flush();

        // J'affiche le rendu d'un fichier twig

        return $this->render('category.html.twig', [
            'category' => $category
        ]);
    }
}