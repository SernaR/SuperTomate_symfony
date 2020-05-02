<?php

namespace App\Controller;

use App\Repository\RecipeRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppController extends AbstractController
{
    /**
     * @Route("/{category}/recettes", name="app_category_recipes")
     */
    public function getCategoryRecipes(RecipeRepository $recipeRepository, $category) 
    {
        return $this->render('app/categoryRecipes.html.twig', [
            'recipes' => $recipeRepository->recipesPerCategory($category),
            'category' => $category
        ]);
    }

    /**
     * @Route("/", name="app_homepage")
     */
    public function index(RecipeRepository $recipeRepository)
    {
        return $this->render('app/homepage.html.twig', [
            'recipes' => $recipeRepository->lastRecipes()
        ]);
    }
}
