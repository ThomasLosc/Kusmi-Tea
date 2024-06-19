<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Repository\AdresseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ProfilType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AdresseType;



class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(AdresseRepository $adresseRepository): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        
        $user = $this->getUser();

        $adresses = $adresseRepository->findBy(['user' => $this->getUser()]);

        return $this->render('profil/index.html.twig', [
            'user' => $user,
            'adresses' => $adresses
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

    #[Route('/profil/adresse/', name: 'app_profil_adresse')]
    public function adresse(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $adresse = new Adresse();
        $form = $this->createForm(AdresseType::class, $adresse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $adresse->setUser($this->getUser());
            $entityManager->persist($adresse);
            $entityManager->flush();

            $this->addFlash('success', 'Vos informations ont bien été modifiées');

            return $this->redirectToRoute('app_profil');
        }

        return $this->render('profil/adresse.html.twig', [
            'form' => $form->createView(),
            'adresse' => $adresse
        ]);
    }
}
