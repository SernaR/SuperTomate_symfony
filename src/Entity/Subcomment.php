<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subcomment
 *
 * @ORM\Table(name="subcomments",)
 * @ORM\Entity(repositoryClass="App\Repository\SubCommentRepository")
 */
class Subcomment
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
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="subComments")
     */
    private $user;

    /**
     * @var \Comment
     *
      * @ORM\ManyToOne(targetEntity="App\Entity\Comment", inversedBy="subComments")
     */
    private $comment;

    
}
