<?php


namespace App\Controller;


use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\True_;
use PhpParser\Node\Expr\New_;
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

        return $this->render('articles.html.twig', [
            'articles' => $articles
        ]);
    }


    /**
     * @Route("/article/show/{id}", name="article_show")
     */
    public function articleShow($id, ArticleRepository $articleRepository)
    {
        $articles = $articleRepository->find($id);

        // en parametre de la méthode, je récupère la valeur de la wildcard id
        // et je demande en plus à symfony d'instancier pour moi
        // la classe ArticleRepository dans une variable $articleRepository
        // (autowire)
        return $this->render('article.html.twig', [
            'article' => $articles
        ]);
    }

    /**
     * @Route("/article/simple-insert", name="article_simple_insert")
     */

    // Je demande à Symfony d'instancier pour moi la classe EntityManager (EntityManagerInterface)
    // dans la variable $entityManager.
    // Cette classe permet de faire les requêtes INSERT, UPDATE et DELETE.

    public function insertSimpleArticle(EntityManagerInterface $entityManager)
    {
        // J'instancie ma classe Entité Article (équivalent de ma table en SQL)
        // pour pouvoir définir les valeurs de ses propriétés (et donc créer un nouvel enregistrement
        // dans la table article en BDD <=> INSERT INTO article() VALUES(); )
        $article = new Article();

        $article->setTitle("« Le retour à la normale ne sera pas pour demain » : Emmanuel Macron annonce un allégement du confinement en trois étapes");
        $article->setContent("Mardi 24 novembre, lors d’une allocution télévisée, Emmanuel Macron les a en tout cas félicités pour avoir passé « le pic de la seconde vague de l’épidémie » de Covid-19, qui connaît aujourd’hui une décroissance à tous niveaux. 20 000 nouveaux cas positifs sont désormais répertoriés au quotidien – contre 60 000 au plus fort de cette vague –, et les services de réanimation dans les hôpitaux comptent 4 300 malades dans leurs chambres, contre 4 900 le 16 novembre. Mais il est encore trop tôt pour apercevoir la ligne d’arrivée tant la persistance du virus bouche l’horizon. « Il nous faut poursuivre nos efforts », a prévenu le chef de l’Etat, qui a présenté un plan de sortie du confinement en trois étapes, ponctué de conditionnalités.");
        $article->setImage("https://img.lemde.fr/2020/11/24/0/0/7779/5186/688/0/60/0/829ddcc_5767081-01-06.jpg");
        $article->setPublicationDate(new \DateTime());
        $article->setCreationDate(new \DateTime());
        $article->setIsPublished(true);

        // Je "pré-sauvegarde" mes modifications avec à la méthode
        // persist de l'EntityManager (comme un commit dans Git)

        //$entityManager->persist($article);

        // J'insère en BDD mes données "pré-sauvegardées" par la méthode persist en utilisant
        // à la méthode flush de l'EntityManager

        //$entityManager->flush();

        // J'affiche le rendu d'un fichier twig

        return $this->render('article.html.twig', [
            'article' => $article
        ]);
    }
}