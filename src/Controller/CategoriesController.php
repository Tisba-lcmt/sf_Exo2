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
        $categories = $categoriesRepository->findAll();

        return $this->render('categories.html.twig', [
            'categories' => $categories
        ]);
    }
}