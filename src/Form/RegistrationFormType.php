<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [ 'label' => 'E-mail :' , 'attr' => array(
                'placeholder' => '*******@mail.fr'
            )])
            ->add('lastname', TextType::class,[ 'label' => 'Nom :'] )
            ->add('firstname', TextType::class,[ 'label' => 'Prénom :'])
            ->add('phone', IntegerType::class,[ 'label' => 'Téléphone :', 'attr' => array(
                'placeholder' => '06********'
            )])
           
            ->add('Address', TextType::class,[ 'label' => 'Adresse :'])
            ->add('city', TextType::class,[ 'label' => 'Ville :'])
            ->add('zipcode', TextType::class, [ 'label' => 'Code Postal :'])
            ->add('country', TextType::class,[ 'label' => 'Pays :', 'attr' => array(
                'placeholder' => 'France'
            )] )
            ->add('RGPDConsent', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
                'label' => 'En m\'inscrivant à ce site j\'accepte les conditions'
            ])
            ->add('plainPassword', PasswordType::class, [ 
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password', 'placeholder' => 'minimum 5 caracteres '],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 35,
                    ]),
                    new Regex([
                       'pattern' => '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{5,}$/', 
                       'message' => 'Veuillez entrer au moins 1 majuscule, 1 minuscule et 1 chiffre'
                    ]),
                ],
                
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
