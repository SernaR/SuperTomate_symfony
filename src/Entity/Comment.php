<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Comment
 *
 * @ORM\Table(name="comments")
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
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
     * @ORM\Column(name="content", type="text", length=65535, nullable=false)
     */
    private $content;

    /**
     * @var bool
     *
     * @ORM\Column(name="isChecked", type="boolean", nullable=false)
     */
    private $ischecked;

    /**
     * @var bool
     *
     * @ORM\Column(name="isBlocked", type="boolean", nullable=false)
     */
    private $isblocked;

    /**
     * @var bool
     *
     * @ORM\Column(name="isReaded", type="boolean", nullable=false)
     */
    private $isreaded;

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
     * @var \User
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comments")
     */
    private $user;

    /**
     * @var \Recipe
     * @ORM\ManyToOne(targetEntity="App\Entity\Recipe", inversedBy="comments")
     */
    private $recipe;

    /**
     * @var \SubComment
     * @ORM\OneToMany(targetEntity="App\Entity\SubComment", mappedBy="comment")
     */
    private $subComments;

    public function __construct()
    {
        $this->subComment = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getIsChecked(): ?bool
    {
        return $this->isChecked;
    }

    public function setIsChecked(bool $isChecked): self
    {
        $this->isChecked = $isChecked;

        return $this;
    }

    public function getIsBlocked(): ?bool
    {
        return $this->isBlocked;
    }

    public function setIsBlocked(bool $isBlocked): self
    {
        $this->isBlocked = $isBlocked;

        return $this;
    }

    public function getIsReaded(): ?bool
    {
        return $this->isReaded;
    }

    public function setIsReaded(bool $isReaded): self
    {
        $this->isReaded = $isReaded;

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

    /**
     * @return Collection|SubComment[]
     */
    public function getSubComment(): Collection
    {
        return $this->subComment;
    }

    public function addSubComment(SubComment $subComment): self
    {
        if (!$this->subComment->contains($subComment)) {
            $this->subComment[] = $subComment;
            $subComment->setComment($this);
        }

        return $this;
    }

    public function removeSubComment(SubComment $subComment): self
    {
        if ($this->subComment->contains($subComment)) {
            $this->subComment->removeElement($subComment);
            // set the owning side to null (unless already changed)
            if ($subComment->getComment() === $this) {
                $subComment->setComment(null);
            }
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
