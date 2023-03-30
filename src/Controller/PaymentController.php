<?php

namespace App\Controller;

use App\Form\BankCardType;
use App\Entity\Orders;
use App\Entity\OrdersDetails;
use App\Repository\ProductsRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\OrdersDetailsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/paiement', name: 'payment_')]
class PaymentController extends AbstractController
{

 
 
    #[Route('/', name: 'index')]
    public function index( Request $request, SessionInterface $session,  ProductsRepository $productsRepository, OrdersDetailsRepository $quantity):Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        /* recupere la session utilisateur */
       
          /* recuperation du panier */
        $panier = $session->get('panier', []);
        
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
         /* recuperation du panier */

      /* si le panier est vide , l'utilisateur ne peut acceder a la page */
         if(empty($panier)){
      return $this->redirectToRoute('cart_index');
      }  /* si le panier est vide , l'utilisateur ne peut acceder a la page */
       
         
        /* ***************** . form bankCard ************************** */ 
         $form = $this->createForm(BankCardType::class); 

         $form->handleRequest($request); 
         if($form->isSubmitted() && $form->isValid()){
         return $this->redirectToRoute('payment_paymentvalidate');
         }
        /* ***************** . form bankCard ************************** */
       

      return $this->render('payment/index.html.twig',/* compact('dataPanier', 'total')  ou */ [ 'dataPanier' => $dataPanier,
       'total' => $total,
       'formulaireBank' => $form->createView() ] );
    }


    
    #[Route('/paiementvalider', name: 'paymentvalidate')]
    public function paymentvalidate(SessionInterface $session,  ProductsRepository $productsRepository, ManagerRegistry $doctrine , OrdersDetailsRepository $ordersDetails ):Response
    {
        $panier = $session->get('panier', []);
        $dataPanier = [];
        $total = 0;
      

        foreach($panier as $id => $quantity){
          $product = $productsRepository->find($id); 
          $product->setStock($product->getStock()-$quantity);
         
        
        
         
         $dataPanier[] = [
             'product' => $product,
             'quantity' => $quantity,
             ];
         
         $total += $product->getPrice() *  $quantity; 
         $entityManager = $doctrine->getManager();
         $entityManager->persist($product);
         $entityManager->flush();
         } 

         /* si le panier est vide , l'utilisateur ne peut acceder a la page */
         if(empty($panier)){
           return $this->redirectToRoute('cart_index');
        }      

        /* si le panier est vide , l'utilisateur ne peut acceder a la page */




         /* *********** remplissage table order ************** */

         $entityManager = $doctrine->getManager();
         $order = new Orders();
         $order->setUsers($this->getUser());
         $order->setReference("ord".random_int(0,99999)."-".random_int(0,9999999));
         $entityManager->persist($order);
         $entityManager->flush(); 
         /* *********** remplissage table order ************** */
         

        
         /* *********** remplissage table ordersdetails ************** */
         $entityManager = $doctrine->getManager();
         $ordersDetails =  new OrdersDetails();
         $ordersDetails->setProducts($product); 
         $ordersDetails->setQuantity($quantity); 
         $ordersDetails->setOrders($order); 
         $ordersDetails->setReference($order->getReference());
         $ordersDetails->setPrice($total); 
         $entityManager->persist($ordersDetails); 
         $entityManager->flush();  
         
         
          /* *********** remplissage table ordersdetails ************** */

        /* *************** vidage du panier apres achat *************** */

         $ordersDetails = 1; 
        
         if($ordersDetails >= 1){     
          $session->remove('panier');
         } 
          
         /* *************** vidage du panier apres achat *************** */

       
         return $this->render('payment/paymentvalidate.html.twig',  compact('dataPanier', 'total'));
    }










}