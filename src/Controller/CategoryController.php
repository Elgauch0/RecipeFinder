<?php



namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/category', name: 'category.')]
class CategoryController extends AbstractController

{

    #[Route(name: 'index')]
    public function index(CategoryRepository $repo)
    {
        $categories = $repo->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories
        ]);
    }


    #[Route('/create', name: 'create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {

        $categorie = new Category();
        $form = $this->createForm(CategoryType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $categorie = $form->getData();
            $em->persist($categorie);
            $em->flush();
            $this->addFlash('success', 'la category  a bien été ajouté');
            return $this->redirectToRoute('app_main');
        }
        return $this->render('category/newCategory.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/edit/{id}', name: 'edit', requirements: ['id' => Requirement::DIGITS], methods: ['GET', 'POST'])]
    public function edit(Category $category, Request $request, EntityManagerInterface $em)
    {

        if (!$em->contains($category)) {
            throw $this->createNotFoundException('Category not managed by EntityManager');
        }

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($category);
            $em->flush();
            $this->addFlash('success', 'la category  a bien été modifié');
            return $this->redirectToRoute('app_main');
        }
        return $this->render('category/edit.html.twig', [
            'form' => $form
        ]);
    }




    #[Route('remove/{id}', name: 'remove', requirements: ['id' => Requirement::DIGITS], methods: ['DELETE'])]
    public function remove(Category $category, EntityManagerInterface $em)
    {
        $em->remove($category);
        $em->flush();
        $this->addFlash('success', 'la category  a bien été suprimé');
        return $this->redirectToRoute('app_main');
    }
}
