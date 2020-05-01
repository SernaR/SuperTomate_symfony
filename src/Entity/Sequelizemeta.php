<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sequelizemeta
 *
 * @ORM\Table(name="sequelizemeta", uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"name"})})
 * @ORM\Entity
 */
class Sequelizemeta
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $name;

    public function getName(): ?string
    {
        return $this->name;
    }


}
