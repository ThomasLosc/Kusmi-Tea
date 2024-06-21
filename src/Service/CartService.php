<?php

namespace App\Service;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{
    private $session;
    private $entityManager;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $entityManager)
    {
        $this->session = $requestStack->getSession();
        $this->entityManager = $entityManager;
    }

    public function addToCart(int $id, int $quantity)
    {
        $cart = $this->session->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id] += $quantity;
        } else {
            $cart[$id] = $quantity;
        }

        $this->session->set('cart', $cart);
    }

    public function removeFromCart(int $id)
    {
        $cart = $this->session->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
        }

        $this->session->set('cart', $cart);
    }

    public function updateQuantity(int $id, int $quantity): array
    {
        $cart = $this->session->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id] = $quantity;
        }

        $this->session->set('cart', $cart);

        $productTotal = $this->calculateProductTotal($id);
        $cartTotal = $this->calculateCartTotal();

        return ['productTotal' => $productTotal, 'cartTotal' => $cartTotal];
    }

    private function calculateProductTotal(int $productId): float
    {
        $cart = $this->session->get('cart', []);
        $quantity = $cart[$productId];
        $product = $this->entityManager->getRepository(Product::class)->find($productId);

        return $quantity * $product->getPrice();
    }

    private function calculateCartTotal(): float
    {
        $cart = $this->session->get('cart', []);
        $cartTotal = 0.0;

        foreach ($cart as $productId => $quantity) {
            $product = $this->entityManager->getRepository(Product::class)->find($productId);
            $cartTotal += $quantity * $product->getPrice();
        }

        return $cartTotal;
    }

    public function getCartContent()
    {
        $cartContent = $this->session->get('cart', []);
        $products = [];

        foreach ($cartContent as $productId => $quantity) {
            $product = $this->entityManager->getRepository(Product::class)->find($productId);

            if ($product) {
                $products[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                ];
            }
        }

        return $products;
    }

    public function getTotalCost()
    {
        $cartContent = $this->getCartContent();
        $totalCost = 0;

        foreach ($cartContent as $item) {
            $totalCost += $item['product']->getPrice() * $item['quantity'];
        }

        // Frais de livraison
        if ($totalCost < 49) {
            $totalCost += 4.5;
        }

        return $totalCost;
    }
}

?>
