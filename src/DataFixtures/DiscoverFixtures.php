<?php

namespace App\DataFixtures;

use App\Entity\Cafe;
use App\Entity\Discover;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class DiscoverFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        $rep = $manager->getRepository(Cafe::class);
        $cafes = $rep->findAll();
    
        $rep = $manager->getRepository(User::class);
        $users = $rep->findAll();

        for ($i = 0; $i < 15; $i++) {
            $cafeRando = $cafes[array_rand($cafes)];
            $userRando = $users[array_rand($users)];

            $discover = new Discover();
            $discover->setCafe($cafeRando);
            $discover->setUser($userRando);

            $cafeRando->addDiscover($discover);
            $userRando->addDiscover($discover);


            $manager->persist($discover);

        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return ([
            CafeFixtures::class,
            UserFixtures::class
        ]);
    }
}
