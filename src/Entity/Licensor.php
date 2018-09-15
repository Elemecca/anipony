<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Licensor
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @var string
     */
    private $name;


    /**
     * @ORM\OneToMany(targetEntity="LicensorProduct", mappedBy="licensor")
     * @var \Doctrine\Common\Collections\Collection
     */
    private $products;


    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return LicensorProduct[]
     */
    public function getProducts()
    {
        return $this->products->toArray();
    }
}
