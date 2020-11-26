<?php


namespace App\Controller;


use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("article/insert", name="article_insert")
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

        $form ->handleRequest($request);

        // Si le form a été envoyé et qu'il est valide, je pré-sauvegarde et j'envoie à la BDD
        // les données saisies dans le formulaire.
        if ($form->isSubmitted() && $form->isValid()) {
            // alors je l'enregistre en BDD
            $entityManager->persist($article);
            $entityManager->flush();
        }

        // Je prends le gabarit de formulaire récupéré et je créé une "vue" de formulaire
        // pour pouvoir l'afficher dans mon fichier twig
        $formView = $form->createView();

        // J'envoie la vue de mon formulaire à twig
        return $this->render('insert.html.twig', [
            'formView' => $formView
        ]);
    }

    /**
     * @Route("article/static-update/{id}", name="article_static_update")
     */

    // J'ai besoin de récupérer un article dans la table article donc je demande
    // à SF d'instancier pour moi l'ArticleRepository.
    // J'ai aussi besoin de re-enregistrer cet article donc je demande à SF
    // d'instancier L'entityManagerInterface (EntityManager).

    public function updateStaticArticle(ArticleRepository $articleRepository, EntityManagerInterface $entityManager, $id)
    {
        // Je récupère l'article a modifier avec la méthode find du repository
        // La méthode find me renvoie une entité Article qui contient toutes les données
        // de l'article (titre, content etc).
        $article = $articleRepository->find($id);

        $article->setTitle('Laurent Fabius : « En étudiant une QPC, nous devons apprécier la balance entre l’intérêt personnel du justiciable et l’intérêt général »');
        $article->setContent('Le Conseil constitutionnel a financé d’importants travaux de recherche universitaire pour faire un bilan juridique et sociologique du recours à la question prioritaire de constitutionalité (QPC). Laurent Fabius, président de l’institution depuis 2016, y voit « une réussite incontestable ». Il annonce la création d’une base de données pour suivre le sort réservé aux QPC par les tribunaux qu’il qualifie actuellement d’« angle mort ».');
        $article->setImage('https://img.lemde.fr/2020/11/23/0/0/5568/3712/688/0/60/0/336e8c6_289810946-000-1bz3wz.jpg');
        $article->setPublicationDate(new \DateTime());
        $article->setCreationDate(new \DateTime());
        $article->setIsPublished(true);

        // Une fois que j'ai modifié mon entité Article
        // je la re-enregistre avec l'entityManager et les méthodes
        // persist puis flush.

        $entityManager->persist($article);
        $entityManager->flush();

        return $this->redirectToRoute('articles_list');
    }

    /**
     * @Route("article/delete/{id}", name="article_delete")
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

        return $this->redirectToRoute('articles_list');
    }
}