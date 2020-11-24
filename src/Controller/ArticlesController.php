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
        $articles = $articleRepository->findAll();

        return $this->render('articles.html.twig', [
            'articles' => $articles
        ]);
    }
}