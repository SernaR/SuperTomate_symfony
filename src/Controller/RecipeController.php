<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecipeController extends AbstractController
{
    private $em;
    
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    /**
     * @Route("utilisateur/recette/{recipe}", name="recipe_edit")
     */
    public function editRecipe(Request $request, Recipe $recipe)
    {
        $originalIngredients = new ArrayCollection();
        foreach ($recipe->getIngredients() as $ingredient) {
            $originalIngredients->add($ingredient);
        }

        $originalSteps = new ArrayCollection();
        foreach ($recipe->getSteps() as $step) {
            $originalSteps->add($step);
        }
        
        return $this->setRecipe($request, $recipe, $originalIngredients, $originalSteps);
    }

    /**
     * @Route("utilisateur/recette", name="recipe_add")
     */
    public function addRecipe(Request $request)
    {
        $recipe = new Recipe();
        $recipe->setUser($this->getUser());

        return $this->setRecipe($request, $recipe, null, null);
    }

    /**
     * set form or set a recipe and redirrect to recipe page
     *
     * @param [type] $request
     * @param [type] $recipe
     * @param [type] $originalIngredients
     * @param [type] $originalSteps
     * @return void
     */
    private function setRecipe($request, $recipe, $originalIngredients, $originalSteps)
    { 
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $ingredients = $recipe->getIngredients();
            $steps = $recipe->getSteps();

            if ($originalIngredients) {
                $this->removeItem($originalIngredients, $ingredients);
                $this->removeItem($originalSteps, $steps);
            }

            $this->setRank($ingredients);
            $this->setRank($steps);

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
    
    /**
     * reset rank when add or remove items
     *
     * @param [type] $originalItems
     * @param [type] $items
     * @return void
     */
    private function setRank($items)
    {
        $rank = 1;
        foreach ( $items as $item) {
            $item->setRank($rank);
            $rank++;
        }
    }

    /**
     * remove item when update
     *
     * @param [type] $originalItems
     * @param [type] $items
     * @return void
     */
    private function removeItem($originalItems, $items)
    {
        foreach ($originalItems as $item) {
            if (false ===  $items->contains($item)) {
                $this->em->remove($item);
            }
        }
    }
}
