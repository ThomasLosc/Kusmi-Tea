<?php 

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class RegistrationQuestion5Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('commentConnuKusmiTea', ChoiceType::class, [
            'label' => 'Comment avez-vous connu Kusmi Tea ?',
            'required' => true,
            'label_attr' => [
                'class' => 'fw-bold'
            ],
            'attr' => [
                'class' => 'input-design mt-2'
            ],
            'placeholder' => '',
            'choices' => [
                'Sur les réseaux sociaux' => 'Sur les réseaux sociaux',
                'En magasin' => 'En magasin',
                'Par un ami' => 'Par un ami',
                'Par un influenceur' => 'Par un influenceur',
                'Sur google' => 'Sur google',
                'Par une publicité' => 'Par une publicité',
                'Autre' => 'Autre',
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
