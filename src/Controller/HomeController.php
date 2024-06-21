<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CategoryRepository $categoryRepository): Response
    {
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

        $categories = $categoryRepository->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'categories' => $categories
        ]);
    }
}
