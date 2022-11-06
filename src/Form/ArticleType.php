<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class,[
                'attr'=>[
                    'placeholder' => "Titre de l'article",
                    'class' => 'form-control'
                ]
            ])
            ->add('category',EntityType::class,[
                'class' => Category::class,
                'choice_label' => 'title',
                'attr'=>[
                    'class' => 'form-control'
                ]
            ])
            ->add('content',TextareaType::class,[
                'attr'=>[
                    'placeholder' => "Contenu de l'article",
                    'class' => 'form-control'
                ]
            ])
            ->add('image',TextType::class,[
                'attr'=>[
                    'placeholder' => "Image de l'article",
                    'class' => 'form-control'
                ]
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
