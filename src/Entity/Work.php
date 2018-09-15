<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/** An individual licensed work.
 * This could be an OVA, an anime series, a manga, etc.
 *
 * @ORM\Entity
 * @ORM\Table(
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(columns={"ani_id"}),
 *     },
 * )
 */
class Work
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /** The main title of the work.
     * @ORM\Column(type="string", length=255, nullable=false)
     * @var string
     */
    private $title;


    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var int
     */
    private $aniId;


    /**
     * @ORM\OneToMany(targetEntity="LicensorProduct", mappedBy="work")
     */
    private $products;


    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    public function getAniId(): ?int
    {
        return $this->aniId;
    }

    public function setAniId(int $id)
    {
        $this->aniId = $id;
    }

    /** @return LicensorProduct[] */
    public function getProducts()
    {
        return $this->products;
    }
}
