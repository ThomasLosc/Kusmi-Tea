<?php 

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class RegistrationQuestion3Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('autreTypeThe', ChoiceType::class, [
            'label' => 'Souhaiteriez-vous que l\'on vous propose d\'autres types de thé ? ',
            'required' => true,
            'label_attr' => [
                'class' => 'fw-bold'
            ],
            'attr' => [
                'class' => 'input-design mt-2'
            ],
            'placeholder' => '',
            'choices' => [
                'OUI' => 'OUI',
                'NON' => 'NON',
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
