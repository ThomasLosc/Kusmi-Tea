<?php

namespace App\Controller;

use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'app_commande')]
    public function index(CommandeRepository $commandeRepository): Response
    {
        
        $commandes = $commandeRepository->findBy(['user' => $this->getUser()]);

        return $this->render('commande/index.html.twig', [
            'commandes' => $commandes,
        ]);
    }
}
