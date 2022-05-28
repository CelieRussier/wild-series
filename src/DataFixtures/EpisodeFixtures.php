<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
//Tout d'abord nous ajoutons la classe Factory de FakerPhp
use Faker\Factory;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        //Puis ici nous demandons à la Factory de nous fournir un Faker
        $faker = Factory::create();

        /**
        * L'objet $faker que tu récupère est l'outil qui va te permettre 
        * de te générer toutes les données que tu souhaites
        */

        for ($i = 1; $i <= 5; $i++) {
            for ($j = 1; $j <= 10; $j++) {
                for ($k = 1; $k <= 10; $k++) {
                    $episode = new Episode();
                    $episode->setTitle($faker->sentence(5));
                    $episode->setNumber($k);
                    $episode->setSynopsis($faker->paragraphs(3, true));
                    $episode->setSeason($this->getReference('program_' . $i . '_season_' . $j));
    
                    $manager->persist($episode);
                }
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
          SeasonFixtures::class,
        ];
    }
}