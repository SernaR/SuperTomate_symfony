<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HighlightRepository")
 */
class Highlight
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RecipeHighlight", mappedBy="highlight")
     */
    private $recipeHighlights;

    public function __construct()
    {
        $this->recipeHighlights = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Collection|RecipeHighlight[]
     */
    public function getRecipeHighlights(): Collection
    {
        return $this->recipeHighlights;
    }

    public function addRecipeHighlight(RecipeHighlight $recipeHighlight): self
    {
        if (!$this->recipeHighlights->contains($recipeHighlight)) {
            $this->recipeHighlights[] = $recipeHighlight;
            $recipeHighlight->setHighlight($this);
        }

        return $this;
    }

    public function removeRecipeHighlight(RecipeHighlight $recipeHighlight): self
    {
        if ($this->recipeHighlights->contains($recipeHighlight)) {
            $this->recipeHighlights->removeElement($recipeHighlight);
            // set the owning side to null (unless already changed)
            if ($recipeHighlight->getHighlight() === $this) {
                $recipeHighlight->setHighlight(null);
            }
        }

        return $this;
    }
}
