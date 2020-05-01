<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Highlight
 *
 * @ORM\Table(name="highlights")
 * @ORM\Entity(repositoryClass="App\Repository\HighlightRepository")
 */
class Highlight
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", length=65535, nullable=false)
     */
    private $content;

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
     * @var \RecipeHighlight
     * @ORM\OneToMany(targetEntity="App\Entity\RecipeHighlight", mappedBy="highlight")
     */
    private $recipeHighlights;

    public function __construct()
    {
        $this->recipeHighlights = new ArrayCollection();
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
