<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Repository\AdresseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ProfilType;
use App\Form\KusmiKlubType;
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

        if ($user) {
            if (empty($user->getFrequencethe())) {
                return $this->redirectToRoute('app_question1');
            } elseif (empty($user->getQuelThe())) {
                return $this->redirectToRoute('app_question2');
            } elseif (empty($user->getQuelGout())) {
                return $this->redirectToRoute('app_question3');
            } elseif (empty($user->getAutreTypeThe())) {
                return $this->redirectToRoute('app_question4');
            } elseif (empty($user->getCommentConnuKusmiTea())) {
                return $this->redirectToRoute('app_question5');
            }
        }

        $adresses = $adresseRepository->findBy(['user' => $this->getUser()]);

        return $this->render('profil/index.html.twig', [
            'user' => $user,
            'adresses' => $adresses
        ]);
    }

    #[Route('/profil/kusmiKlub', name: 'app_kusmi_klub')]
    public function kusmiClub(AdresseRepository $adresseRepository, EntityManagerInterface $entityManager, Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $user = $this->getUser();

        if ($user) {
            if (empty($user->getFrequencethe())) {
                return $this->redirectToRoute('app_question1');
            } elseif (empty($user->getQuelThe())) {
                return $this->redirectToRoute('app_question2');
            } elseif (empty($user->getQuelGout())) {
                return $this->redirectToRoute('app_question3');
            } elseif (empty($user->getAutreTypeThe())) {
                return $this->redirectToRoute('app_question4');
            } elseif (empty($user->getCommentConnuKusmiTea())) {
                return $this->redirectToRoute('app_question5');
            }
        }

        $form = $this->createForm(KusmiKlubType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Vous avez bien rejoint le KusmiKlub');

            return $this->redirectToRoute('app_profil');
        }

        return $this->render('profil/kusmiklub.html.twig', [
            'form' => $form->createView(),
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

        if ($user) {
            if (empty($user->getFrequencethe())) {
                return $this->redirectToRoute('app_question1');
            } elseif (empty($user->getQuelThe())) {
                return $this->redirectToRoute('app_question2');
            } elseif (empty($user->getQuelGout())) {
                return $this->redirectToRoute('app_question3');
            } elseif (empty($user->getAutreTypeThe())) {
                return $this->redirectToRoute('app_question4');
            } elseif (empty($user->getCommentConnuKusmiTea())) {
                return $this->redirectToRoute('app_question5');
            }
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

        $user = $this->getUser();

        if ($user) {
            if (empty($user->getFrequencethe())) {
                return $this->redirectToRoute('app_question1');
            } elseif (empty($user->getQuelThe())) {
                return $this->redirectToRoute('app_question2');
            } elseif (empty($user->getQuelGout())) {
                return $this->redirectToRoute('app_question3');
            } elseif (empty($user->getAutreTypeThe())) {
                return $this->redirectToRoute('app_question4');
            } elseif (empty($user->getCommentConnuKusmiTea())) {
                return $this->redirectToRoute('app_question5');
            }
        }

        $adresse = new Adresse();
        $form = $this->createForm(AdresseType::class, $adresse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $adresse->setUser($this->getUser());
            $entityManager->persist($adresse);
            $entityManager->flush();

            $this->addFlash('success', 'L\'adresse '. $adresse->getNomAdresse() .' a bien été ajoutée');

            return $this->redirectToRoute('app_profil');
        }

        return $this->render('profil/adresse.html.twig', [
            'form' => $form->createView(),
            'adresse' => $adresse
        ]);
    }

    #[Route('/profil/adresse/liste', name: 'app_profil_adresse_liste')]
    public function listeAdresse(Request $request, AdresseRepository $adresseRepository): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $user = $this->getUser();

        if ($user) {
            if (empty($user->getFrequencethe())) {
                return $this->redirectToRoute('app_question1');
            } elseif (empty($user->getQuelThe())) {
                return $this->redirectToRoute('app_question2');
            } elseif (empty($user->getQuelGout())) {
                return $this->redirectToRoute('app_question3');
            } elseif (empty($user->getAutreTypeThe())) {
                return $this->redirectToRoute('app_question4');
            } elseif (empty($user->getCommentConnuKusmiTea())) {
                return $this->redirectToRoute('app_question5');
            }
        }

        $adresses = $adresseRepository->findBy(['user' => $this->getUser()]);

        return $this->render('profil/listeAdresse.html.twig', [
            'adresses' => $adresses
        ]);
    }

    #[Route('/profil/edit/adresse/{id}', name: 'app_profil_adresse_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Adresse $adresse, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AdresseType::class, $adresse);
        $form->handleRequest($request);

        $user = $this->getUser();

        if ($user) {
            if (empty($user->getFrequencethe())) {
                return $this->redirectToRoute('app_question1');
            } elseif (empty($user->getQuelThe())) {
                return $this->redirectToRoute('app_question2');
            } elseif (empty($user->getQuelGout())) {
                return $this->redirectToRoute('app_question3');
            } elseif (empty($user->getAutreTypeThe())) {
                return $this->redirectToRoute('app_question4');
            } elseif (empty($user->getCommentConnuKusmiTea())) {
                return $this->redirectToRoute('app_question5');
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Les informations d l\'adresse ont bien été modifiées');
            return $this->redirectToRoute('app_profil_adresse_liste');
        }

        return $this->render('profil/editAdresse.html.twig', [
            'product' => $adresse,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/profil/adresse/delete/{id}', name: 'app_profil_adresse_delete')]
    public function deleteAdresse(Adresse $adresse, EntityManagerInterface $entityManager, Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $user = $this->getUser();

        if ($user) {
            if (empty($user->getFrequencethe())) {
                return $this->redirectToRoute('app_question1');
            } elseif (empty($user->getQuelThe())) {
                return $this->redirectToRoute('app_question2');
            } elseif (empty($user->getQuelGout())) {
                return $this->redirectToRoute('app_question3');
            } elseif (empty($user->getAutreTypeThe())) {
                return $this->redirectToRoute('app_question4');
            } elseif (empty($user->getCommentConnuKusmiTea())) {
                return $this->redirectToRoute('app_question5');
            }
        }
        
        if ($this->isCsrfTokenValid('delete' . $adresse->getId(), $request->request->get('_token'))) {
            $entityManager->remove($adresse);
            $entityManager->flush();
        }

        $this->addFlash('success', 'L\'adresse a bien été supprimée');

        return $this->redirectToRoute('app_profil_adresse_liste', [], Response::HTTP_SEE_OTHER);
    }
}
