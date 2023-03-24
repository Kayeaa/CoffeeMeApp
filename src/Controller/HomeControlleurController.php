<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeControlleurController extends AbstractController
{
    #[Route('/home/controlleur', name: 'app_home_controlleur')]
    public function index(): Response
    {
        return $this->render('home_controlleur/index.html.twig', [
            'controller_name' => 'HomeControlleurController',
        ]);
    }
}
