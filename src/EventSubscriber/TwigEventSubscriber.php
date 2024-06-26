<?php

// src/EventSubscriber/TwigEventSubscriber.php
namespace App\EventSubscriber;

use App\Service\CartService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

class TwigEventSubscriber implements EventSubscriberInterface
{
    private $twig;
    private $cartService;

    public function __construct(Environment $twig, CartService $cartService)
    {
        $this->twig = $twig;
        $this->cartService = $cartService;
    }

    public function onKernelController(ControllerEvent $event)
    {
        $cartQuantity = count($this->cartService->getCartContent());
        $this->twig->addGlobal('cartQuantity', $cartQuantity);
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
