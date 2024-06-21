<?php 

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class RegistrationQuestion2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quelThe', ChoiceType::class, [
                'label' => 'Quel thé buvez-vous ?',
                'required' => true,
                'label_attr' => [
                    'class' => 'fw-bold'
                ],
                'attr' => [
                    'class' => 'input-design mt-2'
                ],
                'placeholder' => '',
                'choices' => [
                    'Thé vert' => 'Thé vert',
                    'Thé noir' => 'Thé noir',
                    'Thé blanc' => 'Thé blanc',
                    'Infusion' => 'Infusion',
                    'Tisane' => 'Tisane',
                    'Rooibos' => 'Rooibos',
                    'Je ne sais pas' => 'Je ne sais pas',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
