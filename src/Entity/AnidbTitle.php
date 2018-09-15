<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(
 *     indexes={
 *         @ORM\Index(columns={"title"}, flags={"fulltext"}),
 *     },
 * )
 */
class AnidbTitle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @var int
     */
    private $aniId;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     * @var string
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     * @var string
     */
    private $lang;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @var string
     */
    private $title;



    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getAniId(): int
    {
        return $this->aniId;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getLang(): string
    {
        return $this->lang;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}
