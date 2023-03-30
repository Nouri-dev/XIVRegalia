<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegistrationFormType;
use App\Repository\UsersRepository;
use App\Security\UsersAuthenticator;
use App\Service\JWTService;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;


class RegistrationController extends AbstractController
{
    #[Route('/Inscription', name: 'app_register')]
    public function register(Request $request, 
    UserPasswordHasherInterface $userPasswordHasher, 
    UserAuthenticatorInterface $userAuthenticator, 
    UsersAuthenticator $authenticator, 
    EntityManagerInterface $entityManager, 
    SendMailService $mail, 
    JWTService $jwt): Response
    {
        $user = new Users();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();  
          
            // do anything else you need here, like send an email
         

            
            
            
            // generation du JWT de l'utilisateur
            // creation du Header
            $header = [
                'typ' => 'JWT',
                'alg' => 'HS256'
            ];
            // creation du Payload
            $payload = [
                'user_id' => $user->getId()
            ];

            //generation du token
            $token = $jwt->generate($header, $payload, $this->getParameter('app.jwtsecret'));

           



            // envoie du mail d'inscription
            $mail->send(
                 'Admin@mail.fr',
                 $user->getEmail(),
                 'Comfirmation inscription compte XIVREGALIA',
                 'register',
                 compact('user', 'token')
            );

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verif/{token}', name: 'verify_user')]
    public function verifyUser($token, JWTService $jwt, 
    UsersRepository $usersRepository, 
    EntityManagerInterface $em): Response
    {
        //verification si  token est valide, n'a pas expire et na pas été modifier

        if($jwt->isValid($token) && !$jwt->isExpired($token) && $jwt->check($token, $this->getParameter('app.jwtsecret'))){
            //  recup le payload

            $payload = $jwt->getPayload($token);

            // recup le user du token

            $user = $usersRepository->find($payload['user_id']);

            //verification que l'utilisateur existe et n'a pas activer son compte

            if($user && !$user->getIsVerified()){
                $user->setIsVerified(true);
                $em->flush($user);
                $this->addFlash('success', 'Utilisateur activé');
                return $this->redirectToRoute('profile_index');
            }
        }
        // probleme  dans le token si il ne passe dans le if

        $this->addFlash('danger', 'Le token est invalide ou a expiré');
        return $this->redirectToRoute('app_login');
    }

    #[Route('/renvoiverif', name: 'resend_verif')]
    public function resendVerif(JWTService $jwt, 
    SendMailService $mail, 
    UsersRepository $usersRepository): Response
    { 
        // recup le user 

        $user = $this->getUser();

        if(!$user){
            $this->addFlash('danger', 'Vous devez être connecté pour accéder à cette page');
            return $this->redirectToRoute('app_login');    
        }

        if($user->getIsVerified()){
            $this->addFlash('warning', 'Cet utilisateur est déjà activé');
            return $this->redirectToRoute('profile_index');    
        }

        // generation du JWT de l'utilisateur
        // creation du Header
        $header = [
            'typ' => 'JWT',
            'alg' => 'HS256'
        ];

         // creation du Payload
        $payload = [
            'user_id' => $user->getId()
        ];

        //generation du token
        $token = $jwt->generate($header, $payload, $this->getParameter('app.jwtsecret'));

         // envoie du mail d'inscription
        $mail->send(
            'Admin@mail.fr',
            $user->getEmail(),
            'Comfirmation inscription compte XIVREGALIA',
            'register',
            compact('user', 'token')
        );
        $this->addFlash('success', 'Email de vérification envoyé');
        return $this->redirectToRoute('profile_index');
    }
}
