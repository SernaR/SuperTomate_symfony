<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RecipeHighlight
 *
 * @ORM\Table(name="recipehighlights")
 * @ORM\Entity(repositoryClass="App\Repository\RecipeHighlightRepository")
 */
class RecipeHighlight
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="isSelected", type="boolean", nullable=true)
     */
    private $isSelected;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=false)
     */
    private $createdat;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime", nullable=false)
     */
    private $updatedat;

    /**
     * @var \Recipe
     *
    * @ORM\ManyToOne(targetEntity="App\Entity\Recipe", inversedBy="recipeHighlights")
     */
    private $recipe;

    /**
     * @var \Highlight
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Highlight", inversedBy="recipeHighlights")
     */
    private $highlight;

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
