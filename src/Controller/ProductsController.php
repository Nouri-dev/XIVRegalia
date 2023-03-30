<?php

namespace App\Controller;

use App\Entity\Products;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/produits', name: 'products_')]
class ProductsController extends AbstractController
{




    
   

    #[Route('/{slug}', name: 'details')]
    public function details(Products $product, ProductsRepository $productsRepository): Response
    {
        
        return $this->render('products/details.html.twig',[
             'product' => $product,  
             'products' => $productsRepository->findAll() 
        ]);
    }
}
