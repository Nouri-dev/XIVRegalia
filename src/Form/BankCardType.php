<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class BankCardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('carduser', TextType::class,[ 'label' => 'Nom du titulaire de la carte','label_attr' => [
            'class' => 'forma'
        ], 'label_attr' => [
            'class' => 'forma'
        ]
, 'constraints' => [
            new NotBlank([
                'message' => 'Veuillez entrer le nom du titulaire ',
            ]),
            new Length([
                'min' => 2,
                'minMessage' => 'Le nom du titulaire de la carte doit comporter au moins {{ limit }} caractères',
                // max length allowed by Symfony for security reasons
                
            ]),
        ],
        ])


        ->add('cardnumber',  IntegerType::class, [ 'label' => 'Numéro de carte ','label_attr' => [
            'class' => 'forma'], 'attr' => array(
            'placeholder' => 'Entrez les 16 chiffres de votre carte sans espaces'), 'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez entrer votre numéro de carte ',
                ]),
                new Length([
                    'min' => 16,
                    'minMessage' => 'Votre numéro de carte doit comporter au moins {{ limit }} caractères',
                    // max length allowed by Symfony for security reasons
                    'max' => 16,
                    'maxMessage' => 'Votre numéro de carte doit comporter au moins {{ limit }} caractères'
                ]),
            ], 
        ]) 



        ->add('expiry',  IntegerType::class, [ 'label' => 'Expiration carte','label_attr' => [
            'class' => 'forma'
        ] ,'attr' => array(
            'placeholder' => 'MMAA'

        ), 'constraints' => [
            new NotBlank([
                'message' => 'Veuillez entrer la date de la carte ',
            ]),
            new Length([
                'min' => 4,
                'minMessage' => 'La date de la carte doit comporter au moins {{ limit }} caractères',
                // max length allowed by Symfony for security reasons
                'max' => 4,
                'maxMessage' => 'La date de la carte doit comporter au moins {{ limit }} caractères'
            ]),
        ],]) 



         ->add('cvc', PasswordType::class, [ 'label' => 'Cryptogramme visuel' , 'attr' => array(
            'placeholder' => 'CVC'
        ) , 'constraints' => [
            new NotBlank([
                'message' => 'Veuillez entrer votre cryptogramme visuel',
            ]),
            new Length([
                'min' => 3,
                'minMessage' => 'Votre cryptogramme visuel doit comporter au moins {{ limit }} caractères',
                // max length allowed by Symfony for security reasons
                'max' => 4,
                'maxMessage' => 'Votre cryptogramme visuel doit comporter au moins {{ limit }} caractères'
            ]),
        ],
        ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
