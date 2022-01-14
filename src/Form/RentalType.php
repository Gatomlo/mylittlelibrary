<?php

namespace App\Form;

use App\Entity\Rental;
use App\Entity\Borrower;
use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class RentalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('returnStatus',ChoiceType::class,array(
              'label' => 'Rendu ?',
              'attr' => array('class' => 'form-control'),
              'choices' => array(
                'Non' => false,
                'Oui' => true,
                ),
              ))
            ->add('term',IntegerType::class ,array(
              'label' => 'Durée du prêt',
              'data' => 7,
              'attr' => array('class' => 'form-control')))
            ->add('observation',TextareaType::class,array(
              'label' => 'Remarques',
              'attr' => array('class' => 'form-control')))
            ->add('borrower',EntityType::class, array(
              'placeholder' => 'Choisissez une personne',
              'label' => 'Emprunteur',
              'class' => Borrower::class,
              'attr' => array('class' => 'form-control'),
              'choice_label' => "fullName"))
            ->add('books',HiddenType::class,array(
              'mapped'=>false
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rental::class,
        ]);
    }
}
