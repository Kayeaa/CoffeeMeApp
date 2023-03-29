<?php

namespace App\DataFixtures;

use App\Entity\Cafe;
use App\Entity\User;
use App\Entity\Likes;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LikesFixtures extends Fixture implements DependentFixtureInterface
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

            $discover = new Likes();
            $discover->setCafe($cafeRando);
            $discover->setUser($userRando);

            $cafeRando->addLike($discover);
            $userRando->addLike($discover);


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
