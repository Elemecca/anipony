<?php

namespace App\Service;


use App\Entity\Work;
use Doctrine\ORM\EntityManagerInterface;

class AnidbImporter
{
    private $em;
    private $workRepo;
    private $titleRepo;

    private $workCache = [];

    public function __construct(
        EntityManagerInterface $em
    ) {
        $this->em = $em;
        $this->workRepo = $em->getRepository('App:Work');
        $this->titleRepo = $em->getRepository('App:AnidbTitle');
    }


    public function importWork(int $aniId): ?Work
    {
        if (isset($this->workCache[$aniId])) {
            return $this->workCache[$aniId];
        }

        $work = $this->workRepo->findOneBy(['aniId' => $aniId]);
        if (!$work) {
            $aniTitle = $this->titleRepo->findOneBy([
                'aniId' => $aniId,
                'type' => 'main',
            ]);
            if (!$aniTitle) return null;

            $work = new Work();
            $work->setTitle($aniTitle->getTitle());
            $work->setAniId($aniId);
            $this->em->persist($work);
        }

        $this->workCache[$aniId] = $work;
        return $work;
    }
}
