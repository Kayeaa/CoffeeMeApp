<?php

namespace App\Controller;

use App\Entity\Cafe;
use App\Entity\Comment;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentController extends AbstractController
{
    //#[IsGranted('ROLE_ADMIN')]
    #[Route('/comment', name: 'app_comment', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('comment/index.html.twig');
    }

    //#[IsGranted('ROLE_ADMIN','ROLE_CLIENT')]
    #[Route("/comment/add/{id}", name: 'comment_register')]
    public function addComment(Cafe $cafe, Request $req, EntityManagerInterface $manager)
    {
        $comment = new Comment();
        
        $formComment= $this->createForm(CommentType::class, $comment);
        $formComment->handleRequest($req);

        $vars = ['FormComment' => $formComment->createView()];

        if ($formComment->isSubmitted() && $formComment->isValid()){
            if($this->getUser()){
                $user = $this->getUser();
                // dump($user);
                $comment->setUser($user);
            }
    
            $comment->setCafe($cafe);
            $manager->persist($comment);
            $manager->flush();

            $idCafe = $cafe->getId();

            //WANT TO REDIRECT TO CAFE DETAILS.
            return $this->redirectToRoute('cafe_details', ['id' => $idCafe]);
        }
        return $this->render('comment/add.html.twig', $vars);

    }

    //IF YOU ARE THE USER OR ADMIN

    #[Route("/comment/{id}/delete/", name: 'comment_delete', methods : ['GET'])]
    public function commentDelete(ManagerRegistry $doctrine, $id) : Response
    { 
        $em = $doctrine->getManager();
        $oneComment = $em->getRepository(Comment::class)->find($id);

        $em->remove($oneComment);
        $em->flush();
        
        return $this->render('comment/delete.html.twig');

    } 

}
