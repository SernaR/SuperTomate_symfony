<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RecipeHighlightRepository")
 */
class RecipeHighlight
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Recipe", inversedBy="recipeHighlights")
     */
    private $recipe;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Highlight", inversedBy="recipeHighlights")
     */
    private $highlight;

    public function __toString()
    {
        return '-';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRecipe(): ?Recipe
    {
        return $this->recipe;
    }

    public function setRecipe(?Recipe $recipe): self
    {
        $this->recipe = $recipe;

        return $this;
    }

    public function getHighlight(): ?Highlight
    {
        return $this->highlight;
    }

    public function setHighlight(?Highlight $highlight): self
    {
        $this->highlight = $highlight;

        return $this;
    }
}
