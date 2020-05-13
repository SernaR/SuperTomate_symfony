<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use App\Service\RecipeGenerator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecipeController extends AbstractController
{
    /**
     * @Route("utilisateur/recette/{recipe}", name="recipe_edit")
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
     * @Route("utilisateur/recette", name="recipe_add")
     */
    public function addRecipe(Request $request, RecipeGenerator $recipeGenerator)
    {
        $recipe = new Recipe();
        $recipe->setUser($this->getUser());

        return $recipeGenerator->setRecipe($request, $recipe, null, null);
    }

    /**
     * @Route("utilisateur/profil/recettes", name="recipe_user")
     */
    public function userRecipes(RecipeRepository $recipeRepository)
    {
        $user = $this->getUser();
        $recipes = $recipeRepository->findBy(['user' => $user]);

        return $this->render('app/userPages/userRecipes.html.twig', compact('recipes'));
    }
}
