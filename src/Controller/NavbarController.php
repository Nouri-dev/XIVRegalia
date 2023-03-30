<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NavbarController extends AbstractController
{
    #[Route('/Navbar', methods: ['GET'])]
    public function index(): Response
    {
       return $this->render('_partial/_Navbar.html.twig');
    }

}