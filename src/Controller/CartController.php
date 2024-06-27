<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\PointLog;
use App\Form\CommandeType;
use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{

    #[Route('/cart', name: 'app_cart')]
    public function index(CartService $cartService, EntityManagerInterface $entityManagerInterface): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        
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

    #[Route('/cart/commande/', name: 'app_commande_cart', methods: ['POST', 'GET'])]
public function createCommande(CartService $cartService, EntityManagerInterface $entityManager): Response
{

    $cartContent = $cartService->getCartContent();

    if (empty($cartContent)) {
        $this->addFlash('error', 'Votre panier est vide.');
        return $this->redirectToRoute('app_cart');
    }

    $totalPrice = 0.0;
    $totalQuantity = 0;
    $productIds = [];

    foreach ($cartContent as $item) {
        $product = $item['product'];
        $quantity = $item['quantity'];

        $totalPrice += $product->getPrice() * $quantity;
        $totalQuantity += $quantity;
        $productIds[] = $product->getId();
    }

    $totalPoints = $totalPrice;

    if ($totalPrice < 49) {
        $totalPrice += 4.50;
    }

    $commande = new Commande();
    $commande->setPrix($totalPrice);
    $commande->setPoints($totalPoints);
    $commande->setQuantite($totalQuantity);
    $commande->setProductIds($productIds);
    $commande->setDate(new \DateTime());
    $commande->setUser($this->getUser());

    $this->getUser()->addPoints(round($totalPoints));

    $pointLog = new PointLog();
    $pointLog->setUser($this->getUser());
    $pointLog->setLabel('Commande');
    $pointLog->setPoints(round($totalPoints));
    $pointLog->setDate(new \DateTime());

    $entityManager->persist($pointLog);

    $entityManager->persist($commande);
    $entityManager->flush();

    $cartService->clearCart();

    $this->addFlash('success', 'Votre commande a été enregistrée.');

    return $this->redirectToRoute('app_cart');
    }
}