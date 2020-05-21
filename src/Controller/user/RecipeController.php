<?php

namespace App\Controller\user;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use App\Service\RecipeGenerator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("utilisateur")
 */
class RecipeController extends AbstractController
{
    /**
     * @Route("/recette/{recipe}", name="user_recipe_edit")
     */
    public function editRecipe(Request $request, Recipe $recipe, RecipeGenerator $recipeGenerator)
    {
        $originalIngredients = new ArrayCollection();
        foreach ($recipe->getIngredients() as $ingredient) {
            $originalIngredients->add($ingredient);
        }

        $originalSteps = new ArrayCollection();
        foreach ($recipe->getSteps() as $step) {
            $originalSteps->add($step);
        }
        
        return $recipeGenerator->setRecipe($request, $recipe, $originalIngredients, $originalSteps);
    }

    /**
     * @Route("/recette", name="user_recipe_add")
     */
    public function addRecipe(Request $request, RecipeGenerator $recipeGenerator)
    {
        $recipe = new Recipe();
        $recipe->setUser($this->getUser());

        return $recipeGenerator->setRecipe($request, $recipe, null, null);
    }

    /**
     * @Route("/profil/recettes", name="user_recipes")
     */
    public function userRecipes(RecipeRepository $recipeRepository)
    {
        $user = $this->getUser();
        $recipes = $recipeRepository->findBy(['user' => $user]);

        return $this->render('app/userPages/recipes.html.twig', [
            'recipes' => $recipes,
            'current_menu' => 'user'
        ]);
    }
}
