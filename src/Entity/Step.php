<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
//use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StepRepository")
 * 
 */
class Step
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * 
     */
    private $rank;

    /**
     * @ORM\Column(type="text")
     * 
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Recipe", inversedBy="steps")
     */
    private $recipe;

    public function __toString()
    {
        return $this->content;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRank(): ?int
    {
        return $this->rank;
    }

    public function setRank(int $rank): self
    {
        $this->rank = $rank;

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

    public function getRecipe(): ?Recipe
    {
        return $this->recipe;
    }

    public function setRecipe(?Recipe $recipe): self
    {
        $this->recipe = $recipe;

        return $this;
    }
}
