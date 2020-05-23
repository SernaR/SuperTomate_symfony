<?php

namespace App\Service;

use App\Entity\Recipe;
use Doctrine\Common\Collections\ArrayCollection;

class RecipeUtils
{
    /**
        * reset rank when add or remove items
        */
    public function setRank($items)
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
    public function removeItem(ArrayCollection $originalItems, $items, $manager)
    {
        foreach( $originalItems as $item ) {
            if (false ===  $items->contains($item)) {
                $manager->remove($item);
            }
        }
    }

    public function setOriginalIngredients(Recipe $recipe)
    {
        $originalIngredients = new ArrayCollection();
        foreach ($recipe->getIngredients() as $ingredient) {
            $originalIngredients->add($ingredient);
        }
        return $originalIngredients;
    }

    public function setOriginalSteps(Recipe $recipe)
    {
        $originalSteps = new ArrayCollection();
        foreach ($recipe->getSteps() as $step) {
            $originalSteps->add($step);
        }
        return $originalSteps;
    }
}