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
        // Grâce à l'héritage de la classe AbstractController je peux mettre la classe
        // ArticleRepository généréé automatiquement par SF en paramètre de la méthode
        // que j'instancie dans une variable afin de récupérer tous les articles de ma table
        // Article en faisant des requêtes SELECT en BDD.
        // La méthode findAll() de la classe ArticleRepository me permet
        // de récupérer tous les éléments de la table Article.
        $articles = $articleRepository->findAll();

        return $this->render('articles.html.twig', [
            'articles' => $articles
        ]);
    }
}