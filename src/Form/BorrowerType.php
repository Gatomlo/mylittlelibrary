<?php

namespace App\Form;

use App\Entity\Borrower;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class BorrowerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, array(
              'label' => 'Prénom',
              'attr' => array('class' => 'form-control')))
            ->add('lastname', TextType::class, array(
              'label' => 'Nom',
              'attr' => array('class' => 'form-control')))
            ->add('mail', TextType::class, array(
              'label' => 'Email',
              'attr' => array('class' => 'form-control')))
            ->add('phone', TextType::class, array(
              'label' => 'Téléphone',
              'attr' => array('class' => 'form-control')))
            ->add('implantation', ChoiceType::class,array(
              'label' => 'Implantations',
              'attr'=> array('class'=>'form-control'),
              'placeholder' => 'Choisissez une implantation',
              'choices'  => [
                'Ath' => 'Ath',
                'Charleroi' => 'Charleroi',
                'Froyennes' => 'Froyennes',
                'Marcinelle' => 'Marcinelle',
                'Montignies-sur-Sambre' => 'Montignies-sur-Sambre',
                'Mons' => 'Mons',
                'Morlanwelz' => 'Morlanwelz',
                'Tournai' => 'Tournai', ]
            ))
            ->add('department', ChoiceType::class, array(
              'label' => 'Département',
              'attr' => array('class' => 'form-control'),
              'placeholder' => 'Choisissez un département',
              'choices'  => [
                'Agrobiosciences et chimie' => 'Agrobiosciences et chimie',
                'Communication, de l\'éducation et des sciences sociales' => 'Communication, de l\'éducation et des sciences sociales',
                'Santé publique' => 'Santé publique',
                'Arts appliqués' => 'Arts appliqués',
                'Sciences de l\'enseignement' => 'Sciences de l\'enseignement',
                'Sciences de la motricité' => 'Sciences de la motricité',
                'Sciences économiques, juridiques et de gestion' => 'Sciences économiques, juridiques et de gestion',
                'Sciences et des technologies' => 'Sciences et des technologies',
                'Sciences logopédiques' => 'Sciences logopédiques',
                'Marketing, du management touristique et hôtelier' => 'Marketing, du management touristique et hôtelier',
                'Autre' => 'Autre', ]
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Borrower::class,
        ]);
    }
}
