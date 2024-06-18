<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => '<span class="text-danger">*</span> Nom',
                'required' => true,
                'attr' => [
                    'class' => 'input-design mt-2'
                ],
                'label_html' => true,
            ])
            ->add('prenom', TextType::class, [
                'label' => '<span class="text-danger">*</span> Prénom',
                'required' => true,
                'attr' => [
                    'class' => 'input-design mt-2'
                ],
                'label_html' => true,
            ])
            ->add('pays', ChoiceType::class, [
                'label' => '<span class="text-danger">*</span> Pays',
                'required' => true,
                'attr' => [
                    'class' => 'input-design mt-2'
                ],
                'placeholder' => '',
                'choices' => [
                    'France' => 'France',
                    'Allemagne' => 'Allemagne',
                    'Italie' => 'Italie',
                    'Espagne' => 'Espagne',
                    'Portugal' => 'Portugal',
                    'Pays-Bas' => 'Pays-Bas',
                    'Belgique' => 'Belgique',
                    'Suisse' => 'Suisse',
                    'Luxembourg' => 'Luxembourg',
                    'Royaume-Uni' => 'Royaume-Uni',
                    'Irlande' => 'Irlande',
                    'Danemark' => 'Danemark',
                    'Suède' => 'Suède',
                    'Norvège' => 'Norvège',
                ],
                'label_html' => true,
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => '<span class="text-danger">*</span> E-Mail',
                'attr' => [
                    'class' => 'input-design mt-2'
                ],
                'label_html' => true,
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'mapped' => false,
                'invalid_message' => "Les champs du mot de passe doivent correspondre.",
                'constraints' => array(
                    new NotBlank(array(
                        'message' => "Le mot de passe ne peut pas être vide.",
                    )),
                    new Length(array(
                        'min' => 8,
                        'minMessage' => "Le mot de passe doit comporter au moins {{ limit }} caractères."
                    )),
                    new Regex(array(
                        'pattern' => "/^(?=.*[A-Z])/",
                        'message' => "Le mot de passe doit contenir au moins une lettre majuscule."
                    )),
                ),
                'first_options'  => array( 
                    'label' => 'Mot de passe',
                    'attr' => [
                        'class' => 'input-design mb-3',
                    ],
                    'label_attr' => [
                        'class' => 'form-label fw-bold'
                    ],
                ),
                'second_options' => array(
                    'attr' => [
                        'class' => 'input-design',
                    ],
                    'label' => 'Confirmez votre mot de passe :',
                    'label_attr' => [
                        'class' => 'form-label fw-bold'
                    ],
                ),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
