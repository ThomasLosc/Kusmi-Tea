<?php

namespace App\Controller;

use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{

    #[Route('/cart', name: 'app_cart')]
    public function index(CartService $cartService): Response
    {
        $cartContent = $cartService->getCartContent();
        $totalItems = count($cartContent);
        $totalCost = $cartService->getTotalCost();

        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
            'isCartPage' => true,
            'cartContent' => $cartContent,
            'totalItems' => $totalItems,
            'totalCost' => $totalCost,
        ]);
    }

    #[Route('/add-to-cart/{id}/{quantity}', name: 'add-to-cart')]
    public function addToCart(CartService $cartService, int $id, int $quantity): JsonResponse
    {
        $cartService->addToCart($id, $quantity);
        
        return $this->json(['status' => 'success', 'message' => 'Produit ajouté au panier']);
    }

    #[Route('/remove-from-cart/{id}', name: 'remove-from-cart')]
    public function removeFromCart(CartService $cartService, int $id): Response
    {
        $cartService->removeFromCart($id);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/update-cart/{id}', name: 'update-cart', methods: ['POST'])]
    public function updateCart(CartService $cartService, Request $request, int $id): JsonResponse
    {
        $quantity = (int) $request->request->get('quantity', 1);
        $cartUpdate = $cartService->updateQuantity($id, $quantity);
    
        $productTotal = $cartUpdate['productTotal'];
        $cartTotal = $cartUpdate['cartTotal'];
        $shippingCost = $cartTotal < 49 ? 4.50 : 0.00;
    
        return $this->json([
            'productTotal' => $productTotal,
            'cartTotal' => $cartTotal,
            'shippingCost' => $shippingCost,
        ]);
    }
}
