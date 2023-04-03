<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $req, MailerInterface $mailer): Response
    {

        //$form = $this->createForm(ContactType::class);

        //take informatio form the form-request
        //$form->handleRequest($req);

        //if we have data
        // if ($form->isSubmitted() && $form->isValid) {
        //     $data = $form->getData();

        //     //use mailer to send data in an email
        //     $email = $data['email'];
        //     $subject = $data['subject'];
        //     $message = $data['message'];

        //     $email = (new Email())
        //     ->from($email)
        //     ->to('a.rafaele@interface3.be')
        //     ->subject("CoffeeMe".$subject)
        //     ->text($message);

        // $mailer->send($email);

        // }

        return $this->render('contact/index.html.twig', 
        // ['controller_name' => 'ContactController',
        //     'form' =>$form
        // ]
    );
    }
}
