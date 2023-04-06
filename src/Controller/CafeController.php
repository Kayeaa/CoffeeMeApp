<?php

namespace App\Controller;

use App\Entity\Cafe;
use App\Form\CafeType;
use App\Repository\CafeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CafeController extends AbstractController
{
    #[Route('/cafe', name: 'app_cafe', methods: ['GET'])]
    public function index(ManagerRegistry $doctrine): Response
    {
        //FIND ALL CAFES
        $em = $doctrine->getManager();
        $rep = $em->getRepository(Cafe::class);

        $cafes = $rep->findAll();
        $vars = ['cafes' => $cafes];
 
        return $this->render('cafe/index.html.twig', $vars);
    }

    //#[IsGranted('ROLE_ADMIN')]
    #[Route("/cafe/add", name: 'cafe_register')]
    public function addCafe(Request $req, EntityManagerInterface $manager)
    {
        $cafe = new Cafe();
        
        $formCafe = $this->createForm(CafeType::class,$cafe);
        $formCafe->handleRequest($req);

        // on envoie un objet FormView à la vue pour qu'elle puisse 
        // faire le rendu, pas le formulaire en soi
        $vars = ['FormulaireCafe' => $formCafe->createView()];

        if ($formCafe->isSubmitted() && $formCafe->isValid()){
            if($cafe->getPictureFile() !== null){
                $name = uniqid() . '.' . ($cafe->getPictureFile()->guessExtension());
                $cafe->getPictureFile()->move('../public/images', $name);
                $cafe->setPictureUrl('/images/' . $name);
            }
            $manager->persist($cafe);
            $manager->flush();
            return $this->redirectToRoute('app_cafe');
        }

        return $this->render('/cafe/add.html.twig', $vars);
    }



    #[Route('/cafe/{id}', name: 'cafe_details')]
    public function findOneCafe(ManagerRegistry $doctrine, $id): Response
    {
        //FIND ONE CAFES BY ID

        $em = $doctrine->getManager();
        $rep = $em->getRepository(Cafe::class);

        $cafe = $rep->find($id);

        if (!$cafe) {
            throw $this->createNotFoundException('The entity does not exist');
        }
        
        $vars = ['cafe' => $cafe];
      ;
        return $this->render('cafe/details.html.twig', $vars);
    }


    #[Route('cafe/{id}/edit', name: 'cafe_edit', methods: ['GET', 'POST'])] 

    public function edit(Request $request, Cafe $cafe, CafeRepository $cafeRepository): Response 
    { 
        $form = $this->createForm(CafeType::class, $cafe); 

        $form->handleRequest($request); 


        if ($form->isSubmitted() && $form->isValid()) { 

            $cafeRepository->save($cafe, true); 

            return $this->redirectToRoute('app_cafe', [], Response::HTTP_SEE_OTHER);
        } 

        return $this->renderForm('cafe/edit.html.twig', [ 

            'cafe' => $cafe, 
            'form' => $form, 

        ]); 

    } 

     

    #[Route("/cafe/{id}/delete/", name: 'cafe_delete', methods : ['GET'])]
    public function cafeDelete(ManagerRegistry $doctrine, $id)
    { 
        $em = $doctrine->getManager();
        $oneCafe = $em->getRepository(Cafe::class)->find($id);
        
        $em->remove($oneCafe);
        $em->flush();
        return $this->render("cafe/delete.html.twig");

    } 
 
}
