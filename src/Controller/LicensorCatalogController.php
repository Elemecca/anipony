<?php

namespace App\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

        return $this->render('licensor/catalog_edit.html.twig', [
            'licensor' => $lic,
            'products' => $products,
        ]);
    }
}
