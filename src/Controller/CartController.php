<?php

namespace App\Controller;

use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{

    #[Route('/cart', name: 'app_cart')]
    public function index(CartService $cartService): Response
    {
        $cartContent = $cartService->getCartContent();
        $totalItems = count($cartContent);

        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
            'isCartPage' => true,
            'cartContent' => $cartContent,
            'totalItems' => $totalItems,
        ]);
    }

    #[Route('/add-to-cart/{id}/{quantity}', name: 'add-to-cart')]
    public function addToCart(CartService $cartService, int $id, int $quantity): Response
    {
        $cartService->addToCart($id, $quantity);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/remove-from-cart/{id}', name: 'remove-from-cart')]
    public function removeFromCart(CartService $cartService, int $id): Response
    {
        $cartService->removeFromCart($id);

        return $this->redirectToRoute('app_cart');
    }
}
