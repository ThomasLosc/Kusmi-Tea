<?php

namespace App\Form;

use App\Entity\Article;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\CategorieArticle;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom :',
                'required' => true,
                'label_attr' => [
                    'class' => 'label-design mt-3 fw-bold'
                ],
                'attr' => [
                    'class' => 'input-design mt-2'
                ],
            ])
            ->add('description', TextType::class, [
                'label' => 'Description :',
                'required' => true,
                'label_attr' => [
                    'class' => 'label-design mt-3 fw-bold'
                ],
                'attr' => [
                    'class' => 'input-design mt-2'
                ],
            ])
            ->add('text', CKEditorType::class, [
                'label' => 'Article :',
                'required' => true,
                'label_attr' => [
                    'class' => 'label-design mt-3 fw-bold'
                ],
                'attr' => [
                    'class' => 'input-design mt-3'
                ],
            ])
            ->add('categorie', EntityType::class, [
                'class' => CategorieArticle::class,
                'choice_label' => 'nom',
                'label' => 'Catégorie :',
                'placeholder' => '',
                'required' => true,
                'label_attr' => [
                    'class' => 'label-design mt-3 fw-bold'
                ],
                'attr' => [
                    'class' => 'input-design mt-2'
                ],
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => 'Image :',
                'required' => false,
                'allow_delete' => true,
                'download_uri' => false,
                'image_uri' => false,
                'label_attr' => [
                    'class' => 'label-design mt-3 fw-bold'
                ],
                'attr' => [
                    'class' => 'input-design mt-2'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
