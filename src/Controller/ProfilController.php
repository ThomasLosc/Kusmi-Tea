<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ProfilType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;


class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        
        $user = $this->getUser();

        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
            'user' => $user
        ]);
    }

    #[Route('/profil/edit/', name: 'app_profil_edit')]
    public function profil(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        
        $user = $this->getUser();
        $form = $this->createForm(ProfilType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Vos informations ont bien été modifiées');

            return $this->redirectToRoute('app_profil');
        }

        return $this->render('profil/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }
}
