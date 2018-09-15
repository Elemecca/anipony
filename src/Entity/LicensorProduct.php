<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(columns={"licensor_id", "sku"}),
 *     }
 * )
 */
class LicensorProduct
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Licensor", inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     * @var Licensor
     */
    private $licensor;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @var string
     */
    private $sku;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @var string
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="Work", inversedBy="products")
     * @var Work|null
     */
    private $work;



    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Licensor
     */
    public function getLicensor(): Licensor
    {
        return $this->licensor;
    }

    /**
     * @return string
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return Work|null
     */
    public function getWork(): ?Work
    {
        return $this->work;
    }
}
