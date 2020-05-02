<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RecipeRepository")
 */
class Recipe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"recipes_per_category", "homepage"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"recipes_per_category", "recipe", "homepage"})
     * @Assert\NotBlank(message="Le nom  doit être renseigné")
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"recipe"})
     * @Assert\NotBlank(message="Le nombre de part doit être renseigné")
     */
    private $serve;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"recipe"})
     * @Assert\NotBlank(message="Le temps de préparation doit être renseigné")
     */
    private $making;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"recipe"})
     */
    private $cook = 0;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"recipe"})
     */
    private $wait = 0;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"recipes_per_category", "recipe", "homepage"})
     * @Assert\NotBlank(message="La photo est obligatoire")
     */
    private $picture;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"recipe"})
     */
    private $isDraft = false;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"recipes_per_category", "homepage"})
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="recipes")
     * @Groups({"recipe","homepage"})
     * @Assert\NotBlank(message="La catégorie doit être renseigné")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="recipe")
     * 
     */
    private $comments;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Difficulty", inversedBy="recipe")
     * @Groups({"recipe"})
     * @Assert\NotBlank(message="La difficulté doit être renseigné")
     */
    private $difficulty;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ingredient", mappedBy="recipe")
     * @Groups({"recipe"})
     * @Assert\NotBlank(message="Les Ingrédients doivent être renseignés")
     */
    private $ingredients;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Like", mappedBy="recipe")
     * @Groups({"recipe"})
     */
    private $likes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Step", mappedBy="recipe")
     * @Groups({"recipe"})
     * @Assert\NotBlank(message="Les étapesl doivent être renseignées")
     */
    private $steps;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", mappedBy="recipes")
     * @Groups({"recipes_per_category", "recipe", "homepage"})
     * @Assert\NotBlank(message="Les tags doivent être renseignés")
     */
    private $tags;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="recipes")
     * @Groups({"recipe"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RecipeHighlight", mappedBy="recipe")
     */
    private $recipeHighlights;

    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $createdAt;

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
