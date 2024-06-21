<?php 

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\User;

class RegistrationQuestion1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('frequencethe', ChoiceType::class, [
                'label' => 'A quelle fréquence buvez-vous du thé ?',
                'required' => true,
                'label_attr' => [
                    'class' => 'fw-bold'
                ],
                'attr' => [
                    'class' => 'input-design mt-2'
                ],
                'placeholder' => '',
                'choices' => [
                    'De temps en temps' => 'De temps en temps',
                    'Une fois par jour' => 'Une fois par jour',
                    'Plusieurs fois par jour' => 'Plusieurs fois par jour',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
