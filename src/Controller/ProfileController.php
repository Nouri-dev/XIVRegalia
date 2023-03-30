<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\EditPassType;
use App\Form\EditProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;


#[Route('/profil', name: 'profile_')]
class ProfileController extends AbstractController
{
     
   

    #[Route('/', name: 'index')] 
    public function index(): Response
    {
        return $this->render('profile/index.html.twig');
    }


    
    #[Route('/modifier', name: 'modifier')] 
    public function editProfile(Request $request, PersistenceManagerRegistry $doctrine): Response
    {
      
      
        $user = $this->getUser();
        $form = $this->createForm(EditProfileType::class, $user);
        

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $doctrine->getManager();
            $em->persist($user);
            $em->flush();

           /*  $this->addFlash('message', 'Profil mis à jour'); */
           /* probleme a voir le pk du comment  */
            return $this->redirectToRoute('profile_index'); 
        }

        return $this->render('profile/editprofile.html.twig', [
            'form' => $form->createView(),
        ]);
       
    }
    
    /**
     * This controller allow us to edit user's password
     *
     * @param Users $user
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param UserPasswordHasherInterface $hasher
     * @return Response
     */


    #[Route('/motdepasse', name: 'motdepasse', methods: ['GET', 'POST'])] 
    public function editPass(UserAuthenticatorInterface $user, Request $request, UserPasswordHasherInterface $hasher, EntityManagerInterface $manager): Response
    {
       
        $form = $this->createForm(EditPassType::class);
         $user=$this->getUser();
         //dd($user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            if($hasher->isPasswordValid($user, $form->getData()['plainPassword']))
            {
                $user->setPassword(
                    $hasher->hashPassword($user,$form->getData()['newPassword']
                    )
                );

                

                $this->addFlash(
                    'sucess',
                    'Votre mot de passe a bien été modifié'
                );

                $manager->persist($user);
                $manager->flush();

                return $this->redirectToRoute('profile_index');
            }else {
                $this->addFlash(
                    'warning',
                    'Le mot de passe renseigné est incorrect'
                );
            }
        }

      return $this->render('profile/editpass.html.twig', [
        'form' => $form->createView()
      ]);
    }





    #[Route('/commandes', name: 'orders')] 
    public function orders(): Response
    {
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'Commandes de l\'utilisateur',
        ]);
    }
}
