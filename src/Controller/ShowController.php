<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ShowController extends AbstractController
{
    #[Route('/show/{slug}-{id}', name: 'app_show', requirements: ['slug' => '[a-z]+', 'id' => '[0-9]+'])]
    public function index(Request $request, string $slug, int $id): Response
    {

        return $this->render('show/index.html.twig', [
            'slug' => $slug,
            'id' => $id
        ]);
    }
}
