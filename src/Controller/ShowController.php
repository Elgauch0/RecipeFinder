<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Form\RecetteType;
use App\Repository\RecetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use DateTimeImmutable;

class ShowController extends AbstractController
{
    #[Route('/{id}', name: 'app_show', requirements: ['id' => '[0-9]+'])]
    public function index(Request $request,  int $id, RecetteRepository $repo): Response
    {
        $recette = $repo->find($id);


        return $this->render('show/index.html.twig', [
            'recette' => $recette
        ]);
    }

    #[Route('/edit/{id}', name: 'app_edit', requirements: ['id' => '[0-9]+'])]
    public function edit(Recette $recette, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(RecetteType::class, $recette);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $recette->setCreatedAt(new DateTimeImmutable());


            $em->flush();
            return $this->redirectToRoute('app_main');
        }



        return $this->render('show/edit.html.twig', [
            'form' => $form
        ]);
    }
}
