<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title', TextType::class, array(
          'attr' => array('class' => 'form-control')))
            ->add('author', TextType::class, array(
              'attr' => array('class' => 'form-control')))
            ->add('ISBN', TextType::class, array(
              'attr' => array('class' => 'form-control')))
            ->add('image', TextType::class, array(
              'attr' => array('class' => 'form-control')))
            ->add('code', TextType::class, array(
              'attr' => array('class' => 'form-control')))
            ->add('owner', TextType::class, array(
              'attr' => array('class' => 'form-control')))
            ->add('shelf', TextType::class, array(
              'attr' => array('class' => 'form-control')))
            ->add('abstract', TextType::class, array(
              'attr' => array('class' => 'form-control')))
            ->add('paging', TextType::class, array(
              'attr' => array('class' => 'form-control')))
            ->add('editor', TextType::class, array(
              'attr' => array('class' => 'form-control')))
            ->add('price', TextType::class, array(
              'attr' => array('class' => 'form-control')))
            ->add('year', TextType::class, array(
              'attr' => array('class' => 'form-control')))
            ->add('language', TextType::class, array(
              'attr' => array('class' => 'form-control')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
