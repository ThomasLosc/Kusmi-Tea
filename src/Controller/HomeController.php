<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CategoryRepository $categoryRepository, ProductRepository $productRepository): Response
    {
        // Fetch all categories (for navigation or other purposes)
        $categories = $categoryRepository->findAll();

        // Fetch all products (default behavior if no preferences are set)
        $produits = $productRepository->findBy([], ['updatedAt' => 'DESC'], 10); // Example: Fetch 10 latest products

        // Get the current user (assuming user is logged in)
        $user = $this->getUser();

        if ($user) {
            $preferredCategory = null;

            // Check user's preferences
            $preferredTea = $user->getQuelThe();
            $otherTeaPreference = $user->getAutreTypeThe();

            if ($otherTeaPreference !== 'NON') {
                // If user prefers another type of tea, show latest products from that category
                $preferredCategory = $categoryRepository->findOneBy(['name' => $otherTeaPreference]);
            } elseif ($preferredTea) {
                // If user prefers a specific type of tea, show latest products from that category
                $preferredCategory = $categoryRepository->findOneBy(['name' => $preferredTea]);
            }

            if ($preferredCategory) {
                $produits = $productRepository->findBy(
                    ['category' => $preferredCategory],
                    ['updatedAt' => 'DESC'],
                    10 // Example: Limit to 10 latest products
                );
            }
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'categories' => $categories,
            'produits' => $produits
        ]);
    }
}
