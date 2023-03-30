<?php

namespace App\Form;

use App\Entity\Users;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class EditProfileType extends AbstractType
{
   
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('lastname', TextType::class,[ 'label' => 'Nom'])
            ->add('firstname', TextType::class,[ 'label' => 'Prénom'])
            ->add('address', TextType::class,[ 'label' => 'Adresse'])
            ->add('city', TextType::class,[ 'label' => 'Ville'])
            ->add('zipcode', IntegerType::class,[ 'label' => 'Code postal']) 
            ->add('country', TextType::class,[ 'label' => 'Pays'])
             ->add('phone', IntegerType::class,[ 'label' => 'Téléphone'])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
