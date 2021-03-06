<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    
    public function load(ObjectManager $manager)
    {
        
        $program = new Program();
        $program->setTitle('Walking dead');
        $program->setSynopsis('Des zombies envahissent la terre');
        $program->setCategory($this->getReference('category_Action'));
        $this->addReference('program_1', $program);
        $manager->persist($program);

        $program = new Program();
        $program->setTitle('Pocahontas');
        $program->setSynopsis("C'est l'histoire d'une indienne");
        $program->setCategory($this->getReference('category_Animation'));
        $this->addReference('program_2', $program);
        $manager->persist($program);

        $program = new Program();
        $program->setTitle('Ally McBeal');
        $program->setSynopsis('Une avocate rigolote');
        $program->setCategory($this->getReference('category_Comedy'));
        $this->addReference('program_3', $program);
        $manager->persist($program);

        $program = new Program();
        $program->setTitle('Urgences');
        $program->setSynopsis('Des médecins sexy et du love');
        $program->setCategory($this->getReference('category_Medical'));
        $this->addReference('program_4', $program);
        $manager->persist($program);
        
        $program = new Program();
        $program->setTitle('Le bureau des légendes');
        $program->setSynopsis("Série française d'espionnage");
        $program->setCategory($this->getReference('category_Spy'));
        $this->addReference('program_5', $program);
        $manager->persist($program);

        $manager->flush();


    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
          CategoryFixtures::class
        ];
    }

}
