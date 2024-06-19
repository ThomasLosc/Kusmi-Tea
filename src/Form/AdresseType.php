<?php

namespace App\Form;

use App\Entity\Adresse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AdresseType extends AbstractType
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
            ->add('adresse', TextType::class, [
                'label' => '<span class="text-danger">*</span> Adresse',
                'required' => true,
                'attr' => [
                    'class' => 'input-design mt-2'
                ],
                'label_html' => true,
            ])
            ->add('codePostal', TextType::class, [
                'label' => '<span class="text-danger">*</span> Code postal',
                'required' => true,
                'attr' => [
                    'class' => 'input-design mt-2'
                ],
                'label_html' => true,
            ])
            ->add('ville', TextType::class, [
                'label' => '<span class="text-danger">*</span> Ville',
                'required' => true,
                'attr' => [
                    'class' => 'input-design mt-2'
                ],
                'label_html' => true,
            ])
            ->add('telephone', TextType::class, [
                'label' => '<span class="text-danger">*</span> N° téléphone mobile',
                'required' => true,
                'attr' => [
                    'class' => 'input-design mt-2'
                ],
                'label_html' => true,
            ])
            ->add('complementAdresse', TextType::class, [
                'label' => 'Complément d\'adresse',
                'required' => false,
                'attr' => [
                    'class' => 'input-design mt-2'
                ]
            ])
            ->add('nomAdresse', TextType::class, [
                'label' => '<span class="text-danger">*</span> Donnez un nom à cette adresse',
                'required' => true,
                'attr' => [
                    'class' => 'input-design mt-2'
                ],
                'label_html' => true,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adresse::class,
        ]);
    }
}
