<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Form\RecetteType;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends AbstractController
{
    #[Route('/ajouter', name: 'app_ajouter')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $recette = new Recette();


        $form = $this->createForm(RecetteType::class, $recette);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $recette->setCreatedAt(new DateTimeImmutable());
            $recette = $form->getData();
            $em->persist($recette);
            $em->flush();
            $this->addFlash('success', 'la recette a bien été ajouté');



            return $this->redirectToRoute('app_main');
        }

        return $this->render('show/newForm.html.twig', [
            'form' => $form,
        ]);
    }
}
