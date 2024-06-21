<?php 

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class RegistrationQuestion4Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('quelGout', ChoiceType::class, [
            'label' => 'Quel goût préférez-vous ?',
            'required' => true,
            'label_attr' => [
                'class' => 'fw-bold'
            ],
            'attr' => [
                'class' => 'input-design mt-2'
            ],
            'placeholder' => '',
            'choices' => [
                'Agrumes' => 'Agrumes',
                'Floral' => 'Floral',
                'Épicé' => 'Épicé',
                'Fruité' => 'Fruité',
                'Gourmandes' => 'Gourmandes',
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
