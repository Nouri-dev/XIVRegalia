<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker;

class UsersFixtures extends Fixture
{
    private $passwordEncoder;
    private $slugger;

   public function __construct(UserPasswordHasherInterface $passwordEncoder, SluggerInterface $slugger)
   {
    $this->passwordEncoder = $passwordEncoder; 
    $this->slugger = $slugger;
   } 
 

    public function load(ObjectManager $manager): void
    {

         /* ------------- partie administrateur ------------- */

        $admin = new Users();
       $admin->setEmail('Admin@mail.com');
       $admin->setLastname('Nom admin');
       $admin->setFirstname('Prénom admin');
       $admin->setAddress('79 rue de lafayette');
       $admin->setZipcode('78646');
       $admin->setCity('Versailles');
       $admin->setPhone('600000000');
       $admin->setCountry('France');
       $admin->setPassword($this->passwordEncoder->hashPassword($admin, 'Password'));
       $admin->setRoles(['ROLE_ADMIN']);
       $admin->setDate(new \DateTimeImmutable);

       $manager -> persist($admin);

       /* ------------- partie administrateur ------------- */


 
       /* ------------- partie faker utilisateurs ------------- */

       $faker = Faker\Factory::create('fr_FR');
      

       for($usr = 1; $usr <= 5; $usr++){
        $user = new Users();
        $user->setEmail($faker->email);
        $user->setLastname($faker->lastName);
        $user->setFirstname($faker->firstName);
        $user->setAddress($faker->streetAddress);
        $user->setZipcode(str_replace(' ','', $faker->postcode));
        $user->setCity($faker->city);
        $user->setPhone(intval($faker->mobileNumber()));  
        $user->setCountry('France');
        $user->setPassword($this->passwordEncoder->hashPassword($user, 'motdepassesecret'));
        $user->setDate(new \DateTimeImmutable);  
 
        $manager -> persist($user);

       }

        $manager->flush();

       
    }
}
