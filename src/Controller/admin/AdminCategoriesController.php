<?php


namespace App\Controller\admin;


use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoriesController extends AbstractController
{
    /**
     * @Route("/admin/categories", name="admin_categories_list")
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

        return $this->render('category/admin/categories.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/admin/category/insert", name="admin_category_insert")
     */

    public function insertCategory(Request $request, EntityManagerInterface $entityManager)
    {
        // Je créé une nouvelle instance de l'Entité Category
        // pour créer un nouvel enregstrement en bdd et pour pouvoir le lier à mon formulaire.
        $category = new Category();

        // Je veux afficher mon formulaire CategoryType pour créer des catégories.
        // Dans les paramètres de la méthode createForm de l'AbstractController j'indique
        // mon gabarit de formulaire CategoryType pour le récupérer (créé en ligne de commandes)
        // et en indiquant son chemin (::class).

        // Je lie mon formulaire à l'article
        $form = $this->createForm(CategoryType::class, $category);

        // Après avoir lié mon formulaire que j'ai créé au préalable, je peux récupèrer
        // les données saisies lors du remplissage du formulaire grâce à la classe Request
        // instanciée dans une variable $request. Cette variable applique la méthode POST.
        // De cette manière, je pourrai utiliser la variable $form pour vérifier si
        // les données POST ont été envoyées ou pas.

        $form->handleRequest($request);

        // Si le form a été envoyé et qu'il est valide, je pré-sauvegarde et j'envoie à la BDD
        // les données saisies dans le formulaire.
        if ($form->isSubmitted() && $form->isValid()) {
            // alors je l'enregistre en BDD
            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash(
                "success",
                "CATEGORY BIEN AJOUTÉ"
            );

            return $this->redirectToRoute('admin_categories_list');
        }

        // Je prends le gabarit de formulaire récupéré et je créé une "vue" de formulaire
        // pour pouvoir l'afficher dans mon fichier twig

        $formView = $form->createView();

        return $this->render('category/admin/insertCategory.html.twig', [
            'formView' => $formView
        ]);
    }

    /**
     * @Route("/admin/category/update/{id}", name="admin_category_update")
     */

    public function updateCategory(
        $id,
        CategoryRepository $categoryRepository,
        Request $request,
        EntityManagerInterface $entityManager)
    {
        $category = $categoryRepository->find($id);

        if (is_null($category)) {
            return $this->redirectToRoute('admin_categories_list');
        }

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash(
                "success",
                "CATEGORY BIEN MODIFIÉ"
            );
            return $this->redirectToRoute('admin_categories_list');
        }

        $formView = $form->createView();

        return $this->render('category/admin/updateCategory.html.twig', [
           'formView' => $formView
        ]);
    }

    /**
     * @Route("/admin/category/delete/{id}", name="admin_category_delete")
     */

    // Je récupère la wildcard de l'url dans le parametre $id.
    // Je demande à SF d'instancier les classes ArticleRepository et
    // EntityManager (autowire).

    public function deleteCategory(
        $id,
        CategoryRepository $categoryRepository,
        EntityManagerInterface $entityManager
    )
    {
        // Je récupère en BDD l'article dont l'id correspond à celui passé en url (wildcard)
        // pour récupérer l'article en BDD qui correspond à cette wildcard sous forme de
        // requête SQL Select avec un filtre where id.

        $category = $categoryRepository->find($id);

        // Si cet article existe en bdd (donc si la valeur de ma variable $article n'est pas "null")
        // alors je le supprime avec la méthode remove de l'EntityManager.
        if (!is_null($category)) {
            $entityManager->remove($category);
            $entityManager->flush();

            // Si j'ai bien supprimé mon article,
            // j'ajoute un message flash de type "succès"
            // et je lui définis un message
            $this->addFlash(
                "success",
                "CATEGORY BIEN SUPPRIME"
            );
        }
        // Je fais une redirection vers ma page liste d'article une fois la suppression faite.
        return $this->redirectToRoute('admin_categories_list');
    }

}