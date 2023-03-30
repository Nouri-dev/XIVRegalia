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
    public function indexcontact(Request $request, MailerInterface $mailer): Response
    {
        $formCont = $this->createForm(ContactType::class);

        $formCont->handleRequest($request);

       

        if ($formCont->isSubmitted() && $formCont->isValid()){
            
            $data = $formCont->getData();

           
            
          
          
          
             $message = (new Email())
            ->from('Admin@mail.fr',$data['email'])
            ->to('Admin@mail.fr')
            ->subject('Demande de contact  '.$data['name'])
            ->text($data['content']);

            $mailer->send($message); 


         
             $this->addFlash('warning', 'Votre message a été envoyé avec succès'); 

            return $this->redirectToRoute('app_contact'); 
        }


        return $this->render('contact/contact.html.twig', [
            'contactFormulaire' => $formCont->createView()
        ]);
    }
}
