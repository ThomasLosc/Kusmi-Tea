<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\Authenticator;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use App\Form\RegistrationQuestion1Type;
use App\Form\RegistrationQuestion2Type;
use App\Form\RegistrationQuestion3Type;
use App\Form\RegistrationQuestion4Type;
use App\Form\RegistrationQuestion5Type;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, Authenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            // Generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('noreply@kusmitea.fr', 'Kusmi Tea'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );

            // Authenticate the user
            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }
        elseif ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('error', 'Les mots de passe ne correspondent pas ou l\'email existe déjà.');
            return $this->redirectToRoute('app_register');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
    

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_register');
    }

    #[Route('/register/1', name: 'app_question1')]
    public function question1(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_register');
        }

        $user = $this->getUser();

        $form = $this->createForm(RegistrationQuestion1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManagerInterface->persist($user);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_question2');
        }

        return $this->render('registration/question1.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/register/2', name: 'app_question2')]
    public function question2(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_register');
        }

        $user = $this->getUser();

        $form = $this->createForm(RegistrationQuestion2Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManagerInterface->persist($user);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_question3');
        }

        return $this->render('registration/question2.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/register/3', name: 'app_question3')]
    public function question3(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_register');
        }

        $user = $this->getUser();

        $form = $this->createForm(RegistrationQuestion3Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManagerInterface->persist($user);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_question4');
        }

        return $this->render('registration/question3.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/register/4', name: 'app_question4')]
    public function question4(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_register');
        }

        $user = $this->getUser();

        $form = $this->createForm(RegistrationQuestion4Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManagerInterface->persist($user);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_question5');
        }

        return $this->render('registration/question4.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/register/5', name: 'app_question5')]
    public function question5(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_register');
        }

        $user = $this->getUser();

        $form = $this->createForm(RegistrationQuestion5Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManagerInterface->persist($user);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('registration/question5.html.twig', [
            'form' => $form->createView(),
        ]);
    }
        
}
