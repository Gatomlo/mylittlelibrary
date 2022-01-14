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

class RentalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('locationDate', DateType::class ,array(
            'label' => 'Date de l\'emprunt',
            'attr' => array('class' => 'form-control')))
            ->add('returnStatus',ChoiceType::class,array(
            'attr' => array('class' => 'form-control'),
            'choices' => array(
              'Non' => false,
              'Oui' => true,
              ),
            ))
            ->add('term',TextType::class ,array(
              'label' => 'Durée du prêt',
            'attr' => array('class' => 'form-control')))
            ->add('observation',TextareaType::class,array(
              'label' => 'Remarques',
            'attr' => array('class' => 'form-control')))
            ->add('borrower',EntityType::class, array(
              'label' => 'Emprunteur',
              'class' => Borrower::class,
              'attr' => array('class' => 'form-control'),
              'choice_label' => "fullName"))
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rental::class,
        ]);
    }
}
