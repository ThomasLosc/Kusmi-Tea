<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    #[Route('/add/product', name: 'app_product_add')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $product->setUuid(Uuid::v4()->toRfc4122());
            $entityManager->persist($product);
            $entityManager->flush();

            $this->addFlash('success', 'Le produit a bien été ajouté');

            return $this->redirectToRoute('app_product_list');
        }

        return $this->render('product/add.html.twig', [
            'controller_name' => 'ProductController',
            'form' => $form->createView()
        ]);
    }

    #[Route('/product/{uuid}', name: 'app_product_show')]
    public function show($uuid, ProductRepository $productRepository): Response
    {
        $product = $productRepository->findOneBy(['uuid' => $uuid]);

        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }

    #[Route('/list/product', name: 'app_product_list')]
    public function list(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();

        return $this->render('product/list.html.twig', [
            'products' => $products
        ]);
    }

    #[Route('/product/{uuid}/edit', name: 'app_product_edit')]
    public function edit($uuid, Request $request, EntityManagerInterface $entityManager, ProductRepository $productRepository): Response
    {
        $product = $productRepository->findOneBy(['uuid' => $uuid]);
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $entityManager->persist($product);
            $entityManager->flush();

            $this->addFlash('success', 'Le produit a bien été modifié');

            return $this->redirectToRoute('app_product_list');
        }

        return $this->render('product/edit.html.twig', [
            'controller_name' => 'ProductController',
            'form' => $form->createView()
        ]);
    }

    #[Route('/search', name: 'product_search', methods: ['GET'])]
    public function search(Request $request, ProductRepository $productRepository): JsonResponse
    {
        $query = $request->query->get('q');

        if (!$query) {
            return new JsonResponse(['error' => 'Query parameter is missing'], 400);
        }

        $products = $productRepository->createQueryBuilder('p')
            ->where('p.name LIKE :query')
            ->setParameter('query', '%'.$query.'%')
            ->getQuery()
            ->getResult();

        if (empty($products)) {
            return new JsonResponse(['error' => 'No products found'], 404);
        }

        $response = [];
        foreach ($products as $product) {
            $response[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'image' => $product->getImageName(),
                'uuid' => $product->getUuid(),
            ];
        }

        return new JsonResponse($response);
    }
}
