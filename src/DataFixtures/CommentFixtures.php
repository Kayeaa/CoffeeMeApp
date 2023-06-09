<?php

namespace App\DataFixtures;

use App\Entity\Cafe;
use DateTime;
use App\Entity\Comment;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentFixtures extends Fixture implements DependentFixtureInterface
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

            $comment = new Comment();
            $comment->setcreateDate(new DateTime('now'));
            $comment->setMessage("Contenu de commentaire".$i);
            $comment->setCafe($cafeRando);
            $comment->setUser($userRando);

            $cafeRando->addComment($comment);
            $userRando->addComment($comment);


            $manager->persist($comment);

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
