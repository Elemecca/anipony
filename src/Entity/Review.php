<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Review
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;


    /**
     * @ORM\ManyToOne(targetEntity="Work")
     * @ORM\JoinColumn(nullable=false)
     * @var Work
     */
    private $work;


    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var int|null
     */
    private $appropriate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var int|null
     */
    private $horrible;


    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string|null
     */
    private $summary;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string|null
     */
    private $notes;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string|null
     */
    private $english;


    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string|null
     */
    private $tags;


    public function __construct(Work $work)
    {
        $this->work = $work;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Work
     */
    public function getWork(): Work
    {
        return $this->work;
    }

    /**
     * @return int
     */
    public function getAppropriate(): ?int
    {
        return $this->appropriate;
    }

    /**
     * @param int $appropriate
     */
    public function setAppropriate(int $appropriate = null): void
    {
        $this->appropriate = $appropriate;
    }

    /**
     * @return int
     */
    public function getHorrible(): ?int
    {
        return $this->horrible;
    }

    /**
     * @param int $horrible
     */
    public function setHorrible(int $horrible = null): void
    {
        $this->horrible = $horrible;
    }

    /**
     * @return null|string
     */
    public function getSummary(): ?string
    {
        return $this->summary;
    }

    /**
     * @param null|string $summary
     */
    public function setSummary(?string $summary): void
    {
        $this->summary = $summary;
    }

    /**
     * @return null|string
     */
    public function getNotes(): ?string
    {
        return $this->notes;
    }

    /**
     * @param null|string $notes
     */
    public function setNotes(?string $notes): void
    {
        $this->notes = $notes;
    }

    /**
     * @return null|string
     */
    public function getEnglish(): ?string
    {
        return $this->english;
    }

    /**
     * @param null|string $english
     */
    public function setEnglish(?string $english): void
    {
        $this->english = $english;
    }

    /**
     * @return null|string
     */
    public function getTags(): ?string
    {
        return $this->tags;
    }

    /**
     * @param null|string $tags
     */
    public function setTags(?string $tags): void
    {
        $this->tags = $tags;
    }
}
