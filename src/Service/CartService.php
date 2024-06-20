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
}
