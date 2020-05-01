<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Recipe
 *
 * @ORM\Table(name="recipes")
 * @ORM\Entity(repositoryClass="App\Repository\RecipeRepository")
 */
class Recipe
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="serve", type="integer", nullable=false)
     */
    private $serve;

    /**
     * @var int
     *
     * @ORM\Column(name="making", type="integer", nullable=false)
     */
    private $making;

    /**
     * @var int|null
     *
     * @ORM\Column(name="cook", type="integer", nullable=true)
     */
    private $cook;

    /**
     * @var int|null
     *
     * @ORM\Column(name="wait", type="integer", nullable=true)
     */
    private $wait;

    /**
     * @var string
     *
     * @ORM\Column(name="picture", type="string", length=255, nullable=false)
     */
    private $picture;

    /**
     * @var string|null
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=false)
     */
    private $createdat;

    /**
     * @var bool
     *
     * @ORM\Column(name="isDraft", type="boolean", nullable=false)
     */
    private $isdraft;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime", nullable=false)
     */
    private $updatedat;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="recipes")
     */
    private $user;

    /**
     * @var \Category
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="recipe")
     * 
     */
    private $category;

    /**
     * @var \Difficulty
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Difficulty", inversedBy="recipe")
     *
     */
    private $difficulty;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RecipeHighlight", mappedBy="recipe")
     */
    private $recipeHighlights;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", mappedBy="recipes")
     */
    private $tags;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="recipe")
     * 
     */
    private $comments;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ingredient", mappedBy="recipe")
     * 
     */
    private $ingredients;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Like", mappedBy="recipe")
     * 
     */
    private $likes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Step", mappedBy="recipe")
     * 
     */
    private $steps;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->ingredients = new ArrayCollection();
        $this->likes = new ArrayCollection();
        $this->steps = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->recipeHighlights = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getServe(): ?int
    {
        return $this->serve;
    }

    public function setServe(int $serve): self
    {
        $this->serve = $serve;

        return $this;
    }

    public function getMaking(): ?int
    {
        return $this->making;
    }

    public function setMaking(string $making): self
    {
        $this->making = $making;

        return $this;
    }

    public function getCook(): ?int
    {
        return $this->cook;
    }

    public function setCook(int $cook): self
    {
        $this->cook = $cook;

        return $this;
    }

    public function getWait(): ?int
    {
        return $this->wait;
    }

    public function setWait(int $wait): self
    {
        $this->wait = $wait;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getIsDraft(): ?bool
    {
        return $this->isDraft;
    }

    public function setIsDraft(bool $isDraft): self
    {
        $this->isDraft = $isDraft;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setRecipe($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getRecipe() === $this) {
                $comment->setRecipe(null);
            }
        }

        return $this;
    }

    public function getDifficulty(): ?Difficulty
    {
        return $this->difficulty;
    }

    public function setDifficulty(?Difficulty $difficulty): self
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    /**
     * @return Collection|Ingredient[]
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredient $ingredient): self
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients[] = $ingredient;
            $ingredient->setRecipe($this);
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): self
    {
        if ($this->ingredients->contains($ingredient)) {
            $this->ingredients->removeElement($ingredient);
            // set the owning side to null (unless already changed)
            if ($ingredient->getRecipe() === $this) {
                $ingredient->setRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Like[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Like $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setRecipe($this);
        }

        return $this;
    }

    public function removeLike(Like $like): self
    {
        if ($this->likes->contains($like)) {
            $this->likes->removeElement($like);
            // set the owning side to null (unless already changed)
            if ($like->getRecipe() === $this) {
                $like->setRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Step[]
     */
    public function getSteps(): Collection
    {
        return $this->steps;
    }

    public function addStep(Step $step): self
    {
        if (!$this->steps->contains($step)) {
            $this->steps[] = $step;
            $step->setRecipe($this);
        }

        return $this;
    }

    public function removeStep(Step $step): self
    {
        if ($this->steps->contains($step)) {
            $this->steps->removeElement($step);
            // set the owning side to null (unless already changed)
            if ($step->getRecipe() === $this) {
                $step->setRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->addRecipe($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
            $tag->removeRecipe($this);
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
            $recipeHighlight->setRecipe($this);
        }

        return $this;
    }

    public function removeRecipeHighlight(RecipeHighlight $recipeHighlight): self
    {
        if ($this->recipeHighlights->contains($recipeHighlight)) {
            $this->recipeHighlights->removeElement($recipeHighlight);
            // set the owning side to null (unless already changed)
            if ($recipeHighlight->getRecipe() === $this) {
                $recipeHighlight->setRecipe(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

}
