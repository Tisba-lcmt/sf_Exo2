<?php


namespace App\Controller\admin;


use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminArticlesController extends AbstractController
{
    /**
     * @Route("/admin/articles", name="admin_articles_list")
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

        return $this->render('article/admin/articles.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/admin/article/insert", name="admin_article_insert")
     */

    public function insertArticle(
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger
    )
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

            // je récupère mon fichier uploadé dans le formulaire (vu que dans le gabarit
            // de formulaire, j'ai mis ce champs à 'mapped => false"
            $imageFile = $form->get('imageFileName')->getData();

            // si j'ai bien récupéré une image (il peut y avoir des articles
            // uploadés sans image), alors je vais la déplacer puis enregistrer son nom en bdd
            if ($imageFile) {

                // je récupère le nom de l'image
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);

                // grâce à la classe Slugger, je transforme le nom de mon image
                // pour sortir tous les caractères spéciaux (espaces etc)
                $safeFilename = $slugger->slug($originalFilename);

                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();


                // je déplace l'image dans un dossier que j'ai spécifié en parametre
                // (dans le fichier config/services.yaml)
                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                // une fois que j'ai déplacé l'image, j'enregistre le nom de l'image
                // dans mon entité (pour qu'elle soit sauvée en bdd)
                $article->setImageFileName($newFilename);
            }

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
        return $this->render('article/admin/insertArticle.html.twig', [
            'formView' => $formView
        ]);
    }

    /**
     * @Route("/admin/article/update/{id}", name="admin_article_update")
     */

    public function updateArticle(
        $id,
        ArticleRepository $articleRepository,
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger
    )
    {
        $article = $articleRepository->find($id);

        if (is_null($article)) {
            return $this->redirectToRoute('admin_articles_list');
        }

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // je récupère mon fichier uploadé dans le formulaire (vu que dans le gabarit
            // de formulaire, j'ai mis ce champs à 'mapped => false"
            $imageFile = $form->get('imageFileName')->getData();

            // si j'ai bien récupéré une image (il peut y avoir des articles
            // uploadés sans image), alors je vais la déplacer puis enregistrer son nom en bdd
            if ($imageFile) {

                // je récupère le nom de l'image
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);

                // grâce à la classe Slugger, je transforme le nom de mon image
                // pour sortir tous les caractères spéciaux (espaces etc)
                $safeFilename = $slugger->slug($originalFilename);

                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();


                // je déplace l'image dans un dossier que j'ai spécifié en parametre
                // (dans le fichier config/services.yaml)
                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                // une fois que j'ai déplacé l'image, j'enregistre le nom de l'image
                // dans mon entité (pour qu'elle soit sauvée en bdd)
                $article->setImageFileName($newFilename);
            }

            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash(
                "success",
                "ARTICLE BIEN MODIFIÉ"
            );

            return $this->redirectToRoute('admin_articles_list');
        }

        $formView = $form->createView();

        return $this->render('article/admin/updateArticle.html.twig', [
            'formView' => $formView
        ]);
    }

    /**
     * @Route("/admin/article/delete/{id}", name="admin_article_delete")
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