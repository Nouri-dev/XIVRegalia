<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class EditPassType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [  
                    'label' => 'Mot de passe (ancien)',
                    'label_attr' => [
                        'class' => 'formeditpass'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmation du mot de passe (ancien)',
                    'label_attr' => [
                        'class' => 'formeditpass'
                    ]
                ],
                'invalid_message' => 'Les mots de passe ne correspondent pas.'
            ])
            ->add('newPassword', PasswordType::class, [
                
                'label' => 'Nouveau mot de passe',
                'label_attr' => ['class' => 'formeditpass'],
                'constraints' => [new Assert\NotBlank()]
            ])
        ;
    }
}

