<?php

namespace App\Controller;

use App\Repository\RecetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(Request $request, RecetteRepository $repository): Response
    {
        $recipes = $repository->findAll();
        return $this->render('main/index.html.twig', [
            'recettes' => $recipes
        ]);
    }
}
