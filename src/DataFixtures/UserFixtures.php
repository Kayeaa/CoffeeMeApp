<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
    $this->passwordHasher = $passwordHasher;
    }
    
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setName("name". $i);
            $user->setSurname("surname" . $i);
            $user->setCity("city" . $i);
            $user->setCountry("country" . $i);
            $user->setEmail("name" . $i."@coffeeme.com");
            $user->setPassword($this->passwordHasher->hashPassword(
                    $user,'testpassword'
                
                ));
            $user->setRoles(['ROLE_ADMIN']);
            $manager->persist($user);
        }

        for ($i = 5; $i < 10; $i++) {
            $user = new User();
            $user->setName("name". $i);
            $user->setSurname("surname" . $i);
            $user->setCity("city" . $i);
            $user->setCountry("country" . $i);
            $user->setEmail("name" . $i."@coffeeme.com");
            $user->setPassword($this->passwordHasher->hashPassword(
                    $user,'testpassword'
                
                ));
            $user->setRoles(['ROLE_CLIENT']);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
