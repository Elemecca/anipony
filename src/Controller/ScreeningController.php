<?php
/**
 * Created by IntelliJ IDEA.
 * User: sam
 * Date: 9/15/2018
 * Time: 5:52 PM
 */

namespace App\Controller;


use App\Entity\Review;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ScreeningController
extends AbstractController
{

    /**
     * @Route("/screening/{workId}/edit", name="screening_edit")
     */
    public function edit(
        int $workId,
        Request $request,
        EntityManagerInterface $em
    ) {
        $work = $em->getRepository('App:Work')->find($workId);
        $review = $em->getRepository('App:Review')->findOneBy([
            'work' => $work,
        ]);

        if (!$review) {
            $review = new Review($work);
            $em->persist($review);
        }

        $form = $this->createFormBuilder($review)
            ->add('appropriate')
            ->add('horrible')
            ->add('notes')
            ->add('summary')
            ->add('english')
            ->add('tags')
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Saved');
            return $this->redirectToRoute('screening_edit', [
                'workId' => $workId,
            ]);
        }

        return $this->render('screening/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
