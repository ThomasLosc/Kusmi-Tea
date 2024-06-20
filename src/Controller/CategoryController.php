<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category/add', name: 'category_add')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categorySlug = new Slugify();
            $category = $form->getData();
            $category->setSlug($categorySlug->slugify($category->getName()));
            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash('success', 'La catégorie a bien été ajoutée');

            return $this->redirectToRoute('category_add');
        }


        return $this->render('category/add.html.twig', [
            'controller_name' => 'CategoryController',
            'form' => $form->createView()
        ]);
    }
}
