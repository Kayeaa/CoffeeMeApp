<?php

namespace App\Controller;

use App\Entity\Cafe;
use App\Form\CafeType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\DoctrineType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CafeController extends AbstractController
{
    #[Route('/cafe', name: 'app_cafe')]
    public function index(): Response
    {
        return $this->render('cafe/index.html.twig', [
            'controller_name' => 'CafeController',
        ]);
    }

    #[Route("cafe/ajouter", name: 'cafe_register')]
    public function addCafe(Request $req, EntityManagerInterface $manager)
    {
        $cafe = new Cafe();
        
        $formulaireCafe = $this->createForm(CafeType::class,$cafe);
        $formulaireCafe->handleRequest($req);

        // on envoie un objet FormView à la vue pour qu'elle puisse 
        // faire le rendu, pas le formulaire en soi
        $vars = ['FormulaireCafe' => $formulaireCafe->createView()];

        if ($formulaireCafe->isSubmitted() && $formulaireCafe->isValid()){
            if($cafe->getPictureFile() !== null){
                $name = uniqid() . '.' . ($cafe->getPictureFile()->guessExtension());
                $cafe->getPictureFile()->move('../public/images', $name);
                $cafe->setPictureUrl('/images/' . $name);
            }
            $manager->persist($cafe);
            $manager->flush();
            return $this->redirectToRoute('app_home');
        }

        return $this->render('/cafe/ajouter.html.twig', $vars);
    }
}
