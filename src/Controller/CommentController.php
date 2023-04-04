<?php

namespace App\Controller;

use App\Entity\Cafe;
use App\Entity\User;
use App\Entity\Comment;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentController extends AbstractController
{
    #[Route('/comment', name: 'app_comment')]
    public function index(): Response
    {
        return $this->render('comment/index.html.twig');
    }

    //#[IsGranted('ROLE_ADMIN','ROLE_CLIENT')]
    #[Route("/comment/add/{id}", name: 'comment_register', methods:['GET', 'POST'])]
    public function addComment(Cafe $cafe, Request $req, EntityManagerInterface $manager)
    {

        $comment = new Comment();
        $comment->setUser($this->getUser());
        $comment->setCafe($cafe);
        
        $formComment= $this->createForm(CommentType::class, $comment);
        $formComment->handleRequest($req);

        if ($formComment->isSubmitted() && $formComment->isValid()){
            $manager->persist($comment);
            $manager->flush();

            //WANT TO REDIRECT TO CAFE DETAILS.
            return $this->redirectToRoute('cafe_show', ['cafe' => $cafe]);
        }
    }

}
