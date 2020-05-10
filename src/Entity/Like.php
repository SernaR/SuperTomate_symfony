<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
//use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LikeRepository")
 * @ORM\Table(name="`like`")
 * 
 */
class Like
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
    private $record;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Recipe", inversedBy="likes")
     */
    private $recipe;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="likes")
     * 
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRecord(): ?int
    {
        return $this->record;
    }

    public function setRecord(int $record): self
    {
        $this->record = $record;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
