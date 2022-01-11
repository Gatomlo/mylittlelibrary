<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('author')
            ->add('ISBN')
            ->add('image')
            ->add('code')
            ->add('owner')
            ->add('shelf')
            ->add('abstract')
            ->add('paging')
            ->add('editor')
            ->add('price')
            ->add('year')
            ->add('language')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
