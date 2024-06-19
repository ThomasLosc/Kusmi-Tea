<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ProfilType extends AbstractType
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
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => '<span class="text-danger">*</span> E-Mail',
                'attr' => [
                    'class' => 'input-design mt-2'
                ],
                'label_html' => true,
            ])
            ->add('telephone', NumberType::class, [
                'label' => '<span class="text-danger">*</span> Téléphone',
                'required' => true,
                'attr' => [
                    'class' => 'input-design mt-2',
                    'maxlength' => 10,
                    'minlength' => 0
                ],
                'label_html' => true,
            ])
            ->add('dateNaissance', DateType::class, [
                'label' => '<span class="text-danger">*</span> Date de naissance',
                'required' => true,
                'widget' => 'choice',
                'format' => 'dd MM yyyy',
                'attr' => [
                    'class' => 'input-design-date mt-2'
                ],
                'label_html' => true,
                'years' => range(date('Y') - 100, date('Y')),
                'placeholder' => [
                    'year' => 'aaaa', 'month' => 'mm', 'day' => 'jj',
                ],
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
