<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
//Tout d'abord nous ajoutons la classe Factory de FakerPhp
use Faker\Factory;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        //Puis ici nous demandons à la Factory de nous fournir un Faker
        $faker = Factory::create();

        /**
        * L'objet $faker que tu récupère est l'outil qui va te permettre 
        * de te générer toutes les données que tu souhaites
        */
             
            for ($i = 1; $i <= 10; $i++) {
                $actor = new Actor();
                $actor->setName($faker->name());

                
            
                    $actor->addProgram($this->getReference('program_' . rand(1, 5)));
                 
                    $actor->addProgram($this->getReference('program_' . rand(1, 5)));
      
                    $actor->addProgram($this->getReference('program_' . rand(1,5)));

                    $this->addReference('actor_'. $i, $actor);
                    $manager->persist($actor);
    
                $manager->persist($actor);
            }

            $manager->flush();
        }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
          ProgramFixtures::class,
        ];
    }
}