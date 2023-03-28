<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Comment;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CommentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $cafe = new Comment();
            $cafe->setcreateDate(new DateTime('now'));
            $cafe->setMessage("Contenu de commentaire".$i);
            $manager->persist($cafe);
        }
    }
}
