<?php

namespace App\Controller;


use App\Service\AnidbImporter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CollectionController
extends AbstractController
{

    /**
     * @Route("/collection/{collection}/bulk_add", name="collection_bulk_add")
     */
    public function bulk_add(
        int $collection,
        Request $request,
        EntityManagerInterface $em,
        AnidbImporter $anidb
    ) {
        $coll = $em->getRepository('App:Collection')->find($collection);

        if ($request->isMethod('POST')) {
            $count = 0;

            $ids = $request->request->get('ani_ids', '');
            foreach (preg_split('/[\s,]+/', $ids) as $aniId) {
                $work = $anidb->importWork((int)$aniId);
                if (!$work) {
                    $this->addFlash('danger', "invalid ID '$aniId'");
                    continue;
                }

                $coll->addWork($work);
                $count++;
            }

            $em->flush();
            $this->addFlash('success', "Added $count works to collection.");
            return $this->redirectToRoute('collection_bulk_add', [
                'collection' => $collection,
            ]);
        } else {
            return $this->render('collection/bulk_add.html.twig', [
                'collection' => $coll,
            ]);
        }
    }
}
