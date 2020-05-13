<?php

namespace App\Service;

use App\Form\RecipeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecipeGenerator extends AbstractController
{
    private $em;
    
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    } 

    /* 
    * return form and submit recipe
    */
   public function setRecipe($request, $recipe, $originalIngredients, $originalSteps)
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