<?php


namespace App\Controller;


use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController
{
    /**
     * @Route("/articles", name="articles_list")
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

        return $this->render('articles/front/articles.html.twig', [
            'articles' => $articles
        ]);
    }

    // Je créé une url avec une wildcard "id" qui contiendra l'id d'un article.
    /**
     * @Route("/article/show/{id}", name="article_show")
     */
    // en parametre de la méthode, je récupère la valeur de la wildcard id
    // et je demande en plus à symfony d'instancier pour moi
    // la classe ArticleRepository dans une variable $articleRepository
    // (autowire)

    public function articleShow($id, ArticleRepository $articleRepository)
    {
        // J'utilise l'ArticleRepository avec la méthode find pour faire
        // une requête SQL SELECT en BDD et retrouver l'article dont l'id correspond à l'id passé en URL
        $articles = $articleRepository->find($id);

        // Les afficher dans un fichier twig
        return $this->render('articles/front/article.html.twig', [
            'article' => $articles
        ]);
    }
}