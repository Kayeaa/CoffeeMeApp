<?php

namespace App\Controller;

use App\Entity\Cafe;
use App\Form\CafeType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CafeController extends AbstractController
{
    #[Route('/cafe', name: 'app_cafe')]
    public function index(ManagerRegistry $doctrine): Response
    {
        //FIND ALL CAFES
        $em = $doctrine->getManager();
        $rep = $em->getRepository(Cafe::class);

        $cafes = $rep->findAll();
        $vars = ['cafes' => $cafes];
 
        return $this->render('cafe/index.html.twig', $vars);
    }

    #[Route('/cafe/{id}')]
    public function findOneCafe(ManagerRegistry $doctrine, $id): Response
    {
        //FIND ONE CAFES BY ID
        $em = $doctrine->getManager();
        $rep = $em->getRepository(Cafe::class);

        $cafe = $rep->find($id);

        if (!$cafe) {
            throw $this->createNotFoundException('The entity does not exist');
        }
        
        $vars = ['oneCafe' => $cafe];
 
        return $this->render('details.html.twig', $vars);
    }


    #[IsGranted('ROLE_ADMIN')]
    #[Route("/cafe/add", name: 'cafe_register')]
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

    #[Route ("/allcafe", name: 'allcafe')]
    public function allcafe(ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $rep = $em->getRepository(Cafe::class);

        $cafes = $rep->findAll();
        $vars = ['cafe' => $cafes];

        return $this->render("allcafe.html.twig", $vars);
    }
}
