<?php

namespace App\Controller;

use App\Entity\Products;
use App\Repository\UsersRepository; 
use App\Repository\ProductsRepository;
use App\Repository\OrdersDetailsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/cart', name: 'cart_')]
class CartController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(SessionInterface $session, ProductsRepository $productsRepository, OrdersDetailsRepository $quantity, UsersRepository $usersRepository ): Response
    {
        
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');


         $user = $this->getUser();
        if($user->getIsVerified() == 0){

            return $this->redirectToRoute('home.index');
        }  
        /* pour comfirmer le compte */

        

        $panier = $session->get('panier', []);

        // fabrication des donnéé
        $dataPanier = [];
        $total = 0;
       
      
        foreach($panier as $id => $quantity){
             $product = $productsRepository->find($id); 
             
             $dataPanier[] = [
                'product' => $product,
                'quantity' => $quantity,
                ];
            
            $total += $product->getPrice() *  $quantity; 
           } 

        
       
         return $this->render('cart/index.html.twig', compact('dataPanier', 'total') );
    }


    /* ajouter un produit */

    #[Route('/add/{id}', name: 'add')]
    public function add(Products $product, SessionInterface $session)
    {
       // il faut recuperer le panier actuel
       
       $panier = $session->get('panier', []);
       $id = $product->getId();
       
       
     
       if(!empty($panier[$id])){
       
       $panier[$id]++;
       } else {
        $panier[$id] = 1;
       } 
       
       // sauvegarde dans la session

       $session->set('panier', $panier);

     return $this->redirectToRoute('cart_index');
    }

    
    /*   reduire la quantitéd d'un  prduit  */
     
    #[Route('/remove/{id}', name: 'remove')]
    public function remove(Products $product, SessionInterface $session)
    {
       // il faut recuperer le panier actuel
       
       $panier = $session->get('panier', []);
       $id = $product->getId();
       
       
     
       if(!empty($panier[$id])){
          if($panier[$id] > 1){
              $panier[$id]--;
          }else{
            unset($panier[$id]);
          }
       }
       
       // sauvegarde dans la session

       $session->set('panier', $panier);
       
      return $this->redirectToRoute('cart_index');
    }


    /* supprimer la tout le produit  */

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Products $product, SessionInterface $session)
    {
         // il faut recuperer le panier actuel


        $panier = $session->get('panier', []);
        $id = $product->getId();

        if(!empty($panier[$id])){
            unset($panier[$id]);
        }

        // sauvegarde dans la session
        $session->set('panier', $panier);

        return $this->redirectToRoute('cart_index');
    }


    /* vider completement le panier */

    #[Route('/delete', name: 'delete_all')]
    public function deleteAll(SessionInterface $session)
    {
        $session->remove('panier');

        return $this->redirectToRoute('cart_index');
    }


    #[Route('/valideorder', name: 'valideorder')]
    public function valideOrder()
    {
       
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->redirectToRoute('cart_index');
    }


}
