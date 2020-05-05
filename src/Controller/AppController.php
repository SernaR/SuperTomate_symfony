<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Repository\RecipeHighlightRepository;
use App\Repository\RecipeRepository;
use App\Repository\TagRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppController extends AbstractController
{
    /**
     * @Route("/{categorySlug}/{recipeSlug}/{recipe}", name="app_recipe")
     */
    public function getRecipe(RecipeRepository $recipeRepository, Recipe $recipe) {
        return $this->render('app/recipe.html.twig', [
            'recipe' => $recipeRepository->find($recipe)
        ]);
    }

    /**
     * @Route("/{categorySlug}/recettes", name="app_category_recipes")
     */
    public function getCategoryRecipes(RecipeRepository $recipeRepository, TagRepository $tagRepository, $categorySlug) 
    {
        $recipes = $recipeRepository->recipesPerCategory($categorySlug);
        return $this->render('app/categoryRecipes.html.twig', [
            'recipes' => $recipes,
            'tags' => $tagRepository->findAll(),
            'category' => $recipes ? $recipes[0]->getcategory()->getName() : $categorySlug
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
