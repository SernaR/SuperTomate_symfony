<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Repository\RecipeHighlightRepository;
use App\Repository\RecipeRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppController extends AbstractController
{
    /**
     * @Route("/{category}/{slug}/{recipe}", name="app_recipe")
     */
    public function getRecipe(RecipeRepository $recipeRepository, Recipe $recipe) {
        return $this->render('app/recipe.html.twig', [
            'recipe' => $recipeRepository->find($recipe)
        ]);
    }

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
    public function index(RecipeRepository $recipeRepository, RecipeHighlightRepository $recipeHighlightRepository)
    {
        return $this->render('app/homepage.html.twig', [
            'recipes' => $recipeRepository->lastRecipes(),
            'headline' =>$recipeHighlightRepository->headline()
        ]);
    }

    
}
