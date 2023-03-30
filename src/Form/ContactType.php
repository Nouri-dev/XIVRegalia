<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'NOM', 'label_attr' => [
                'class' => 'contactNom'], 'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre Nom. ',
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Votre Nom doit comporter au moins {{ limit }} caractères.',
                        // max length allowed by Symfony for security reasons
                        'max' => 80,
                        'maxMessage' => 'Votre Nom doit comporter maximum {{ limit }} caractères.'
                    ]),
                ],
            ])


            ->add('email', EmailType::class, ['label' => 'E-MAIL ', 'label_attr' => [
                'class' => 'contactMail'], 'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre E-MAIL. ',
                    ]),
                ],
            ])


            ->add('content', TextareaType::class, ['label' => 'MESSAGE', 'label_attr' => [
                'class' => 'contactMess'], 'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre message. ',
                    ]),
                ],    
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
