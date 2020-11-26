<?php


namespace App\Controller;


use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminArticlesController extends AbstractController
{
    /**
     * @Route("admin/articles", name="admin_articles_list")
     */

    public function articlesList(ArticleRepository $articleRepository)
    {
        // Grâce à l'injection de dépendance de Symfony je peux mettre la classe
        // ArticleRepository généréé automatiquement par SF en paramètre de la méthode
        // que j'instancie dans une variable afin de récupérer tous les articles de ma table
        // Article en faisant des requêtes SELECT en BDD.
        // La méthode findAll() de la classe ArticleRepository me permet
        // de récupérer tous les éléments de la table Article.
        $articles = $articleRepository->findAll();

        // Les afficher dans un fichier twig

        return $this->render('articles/admin/articles.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("admin/article/insert", name="admin_article_insert")
     */

    public function insertArticle(Request $request, EntityManagerInterface $entityManager)
    {
        // Je créé une nouvelle instance de l'Entité Article
        // pour créer un nouvel enregstrement en bdd et pour pouvoir le lier à mon formulaire.
        $article = new Article();


        // Je veux afficher mon formulaire ArticleType pour créer des articles.
        // Dans les paramètres de la méthode createForm de l'AbstractController j'indique
        // mon gabarit de formulaire ArticleType pour le récupérer (créé en ligne de commandes)
        // et en indiquant son chemin (::class).

        // Je lie mon formulaire à l'article.
        $form = $this->createForm(ArticleType::class, $article);


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
            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash(
                "success",
                "ARTICLE BIEN AJOUTÉ"
            );

            return $this->redirectToRoute('admin_articles_list');
        }

        // Je prends le gabarit de formulaire récupéré et je créé une "vue" de formulaire
        // pour pouvoir l'afficher dans mon fichier twig
        $formView = $form->createView();

        // J'envoie la vue de mon formulaire à twig
        return $this->render('articles/admin/insert.html.twig', [
            'formView' => $formView
        ]);
    }

    /**
     * @Route("admin/article/update/{id}", name="admin_article_update")
     */

    public function updateArticle(
        $id,
        ArticleRepository $articleRepository,
        Request $request,
        EntityManagerInterface $entityManager)
    {
        $article = $articleRepository->find($id);

        if (is_null($article)) {
            return $this->redirectToRoute('admin_articles_list');
        }

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash(
                "success",
                "ARTICLE BIEN MODIFIÉ"
            );

            return $this->redirectToRoute('admin_articles_list');
        }

        $formView = $form->createView();

        return $this->render('articles/admin/update.html.twig', [
            'formView' => $formView
        ]);
    }

    /**
     * @Route("admin/article/delete/{id}", name="admin_article_delete")
     */

    // Je récupère la wildcard de l'url dans le parametre $id.
    // Je demande à SF d'instancier les classes ArticleRepository et
    // EntityManager (autowire).

    public function deleteArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager)
    {
        // Je récupère en BDD l'article dont l'id correspond à celui passé en url (wildcard)
        // pour récupérer l'article en BDD qui correspond à cette wildcard sous forme de
        // requête SQL Select avec un filtre where id.

        $article = $articleRepository->find($id);

        // Si cet article existe en bdd (donc si la valeur de ma variable $article n'est pas "null")
        // alors je le supprime avec la méthode remove de l'EntityManager.
        if (!is_null($article)) {
            $entityManager->remove($article);
            $entityManager->flush();

            // Si j'ai bien supprimé mon article,
            // j'ajoute un message flash de type "succès"
            // et je lui définis un message
            $this->addFlash(
                "success",
                "ARTICLE BIEN SUPPRIME"
            );
        }

        // Je fais une redirection vers ma page liste d'article une fois la suppression faite.
        return $this->redirectToRoute('admin_articles_list');
    }
}