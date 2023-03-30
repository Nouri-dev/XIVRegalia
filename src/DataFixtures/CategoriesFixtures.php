<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;


class CategoriesFixtures extends Fixture
{

    private $counter = 1;
    
    private $slugger;

    public function __construct( SluggerInterface $slugger)
    {
     $this->slugger = $slugger;
    } 

   
    
    public function load(ObjectManager $manager): void
    {
           /* ---------- categorie homme ------- */

        $parent = $this->createCategory('HOMME', null, $manager);

        $this->createCategory('Prêt-à-porter HOMME', $parent, $manager,);
        $this->createCategory('Accessoires HOMME', $parent, $manager);
        $this->createCategory('Chaussures HOMME', $parent, $manager);
       


          /* ---------- categorie femme ------- */

        $parent = $this->createCategory('FEMME', null, $manager);

        $this->createCategory('Prêt-à-porter FEMME', $parent, $manager);
        $this->createCategory('Accessoires FEMME', $parent, $manager);
        $this->createCategory('Chaussures FEMME', $parent, $manager);
      


          /* ---------- categorie enfant ------- */

        $parent = $this->createCategory('ENFANT', null, $manager);

        $this->createCategory('Prêt-à-porter ENFANT', $parent, $manager);
        $this->createCategory('Accessoires ENFANT', $parent, $manager);
        $this->createCategory('Chaussures ENFANT', $parent, $manager);
     



          /* ---------- categorie Bijoux & Montres ------- */

        $parent = $this->createCategory('BIJOUX & MONTRES', null, $manager);

        $this->createCategory('Bijoux & Montres HOMME', $parent, $manager);
        $this->createCategory('Bijoux & Montres FEMME', $parent, $manager);
    
        

       
    $manager->flush();
    }

    public function createCategory(string $name, Categories $parent = null, ObjectManager $manager)
    {
        $category = new Categories();
        $category->setName($name);
        $category->setSlug($this->slugger->slug($category->getName())->lower());
        $category->setParent($parent);
        $manager->persist($category);


        $this->addReference('cat-'.$this->counter, $category);
        $this->counter++;

        return $category;


    }

    
}
