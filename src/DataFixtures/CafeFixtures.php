<?php

namespace App\DataFixtures;

use App\Entity\Cafe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CafeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $cafe = new Cafe();
            $cafe->setName("cafe". $i);
            $cafe->setPictureUrl("surname" . $i);
            $cafe->setBox("box" . $i);
            $cafe->setNumber($i);
            $cafe->setStreet("street" .$i);
            $cafe->setZipCode($i);
            $cafe->setCity("city" . $i);
            $cafe->setCountry("country" . $i);
            $manager->persist($cafe);
        }

        $manager->flush();
    }
}
