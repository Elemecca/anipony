<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Collection
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
     * @ORM\ManyToMany(targetEntity="Work")
     * @var \Doctrine\Common\Collections\Collection
     */
    private $works;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Work[]
     */
    public function getWorks()
    {
        return $this->works->toArray();
    }

    public function addWork(Work $work)
    {
        if (!$this->works->contains($work)) {
            $this->works->add($work);
        }
    }

    public function containsWork(Work $work)
    {
        return $this->works->contains($work);
    }

    public function removeWork(Work $work)
    {
        $this->works->removeElement($work);
    }
}
