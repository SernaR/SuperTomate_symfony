<?php

namespace App\Controller\user;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Service\RecipeUtils;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("utilisateur")
 */
class RecipeController extends AbstractController
{
    private $em;
    
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route("/recette/{recipe}", name="user_recipe_edit")
     */
    public function editRecipe(Request $request, Recipe $recipe, RecipeUtils $recipeUtils)
    {
        $originalIngredients = $recipeUtils->setOriginalIngredients($recipe);
        $originalSteps = $recipeUtils->setOriginalSteps($recipe);
        
        return $this->setRecipe($recipeUtils, $request, $recipe, $originalIngredients, $originalSteps);
    }

    /**
     * @Route("/recette", name="user_recipe_add")
     */
    public function addRecipe(Request $request, RecipeUtils $recipeUtils)
    {
        $recipe = new Recipe();
        $recipe->setUser($this->getUser());

        return $this->setRecipe($recipeUtils, $request, $recipe, null, null);
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

    /* 
    * return form and submit recipe
    */
    
    private function setRecipe($recipeUtils, $request, $recipe, $originalIngredients, $originalSteps)
    { 
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->getClickedButton() === $form->get('saveDraft')){
                $recipe->setIsDraft(true);
            } else {
                $recipe->setIsDraft(false);
            }

            $ingredients = $recipe->getIngredients();
            $steps = $recipe->getSteps();

            if ($originalIngredients) {
                $recipeUtils->removeItem($originalIngredients, $ingredients, $this->em);
                $recipeUtils->removeItem($originalSteps, $steps, $this->em);
            }

            $recipeUtils->setRank($ingredients);
            $recipeUtils->setRank($steps);

            $this->em->persist($recipe);
            $this->em->flush();
        
            return $this->redirectToRoute('app_recipe', [
                'categorySlug' => $recipe->getCategory()->getSlug(),
                'recipeSlug' => $recipe->getSlug(),
                'recipe' => $recipe->getId()
            ]);
        }
    
        return $this->render('app/recipePages/addRecipe.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
