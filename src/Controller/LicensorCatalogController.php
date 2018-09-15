<?php

namespace App\Controller;


use App\Entity\Work;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LicensorCatalogController
extends AbstractController
{

    /**
     * @Route("/licensor/{licensor}/catalog/", name="lic_catalog")
     */
    public function view(
        int $licensor,
        EntityManagerInterface $em
    ) {
        $lic = $em->getRepository('App:Licensor')->find($licensor);
        $products = $em
            ->getRepository('App:LicensorProduct')
            ->findBy(['licensor' => $lic])
        ;

        return $this->render('licensor/catalog_view.html.twig', [
            'licensor' => $lic,
            'products' => $products,
        ]);
    }


    /**
     * @Route("/licensor/{licensor}/catalog/associate", name="lic_catalog_associate")
     */
    public function associate(
        int $licensor,
        Request $request,
        EntityManagerInterface $em
    ) {
        $lic = $em->getRepository('App:Licensor')->find($licensor);
        $products = $em
            ->getRepository('App:LicensorProduct')
            ->findBy(['licensor' => $lic])
        ;

        $aniTitles = $em->getRepository('App:AnidbTitle');
        $works = $em->getRepository('App:Work');

        if ($request->isMethod('POST')) {
            $workCache = [];
            $vals = $request->request->get('products');
            foreach ($products as $product) {
                $prodId = $product->getId();
                if (empty($vals[$prodId])) continue;
                $aniId = $vals[$prodId];


                if (isset($workCache[$aniId])) {
                    $work = $workCache[$aniId];
                } else {
                    $work = $works->findOneBy(['aniId' => $aniId]);
                }

                if (!$work) {
                    $aniTitle = $aniTitles->findOneBy([
                        'aniId' => $aniId,
                        'type' => 'main',
                    ]);
                    if (!$aniTitle) continue;

                    $work = new Work();
                    $work->setTitle($aniTitle->getTitle());
                    $work->setAniId($aniId);
                    $em->persist($work);
                }

                $workCache[$aniId] = $work;
                $product->addWork($work);
            }

            $em->flush();
            return $this->redirectToRoute('lic_catalog_associate', [
                'licensor' => $licensor,
            ]);
        } else {
            return $this->render('licensor/catalog_edit.html.twig', [
                'licensor' => $lic,
                'products' => $products,
            ]);
        }
    }
}
