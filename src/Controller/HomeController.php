<?php


namespace App\Controller;


use App\Repository\CategoriesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /* *************** page ACCEUIL **************************  */
    #[Route('/', 'home.index', methods: ['GET'])]
    public function index(): Response
    {
       return $this->render('home/home.html.twig');
    }


    /* *************** page Homme **************************  */
    #[Route('/HOMME', name: 'app_mencategories')]
    public function indexmen(CategoriesRepository $categoriesRepository): Response
    {
           return $this->render('home/mencategories.html.twig', [
            'categories' => $categoriesRepository->findBy(['name' => array('Prêt-à-porter HOMME', 'Accessoires HOMME', 'Chaussures HOMME')])
            ]);
    }

    /* *************** page femme **************************  */
    #[Route('/FEMME', name: 'app_womencategories')]
    public function indexwomen(CategoriesRepository $categoriesRepository): Response
    {
        return $this->render('home/womencategories.html.twig', [
            'categories' => $categoriesRepository->findBy(['name' => array('Prêt-à-porter FEMME', 'Accessoires FEMME', 'Chaussures FEMME')])
            ]);
    }

    /* *************** page enfant **************************  */
    #[Route('/ENFANT', name: 'app_childrencategories')]
    public function indexchil(CategoriesRepository $categoriesRepository): Response
    {
        return $this->render('home/childrencategories.html.twig', [
            'categories' => $categoriesRepository->findBy(['name' => array('Prêt-à-porter ENFANT', 'Accessoires ENFANT', 'Chaussures ENFANT')])
            ]);
    }

    /* *************** page BIJOUX & MONTRES **************************  */
    #[Route('/BIJOUX&MONTRES', name: 'app_jewelerycategories')]
    public function indexjewel(CategoriesRepository $categoriesRepository): Response
    {
        return $this->render('home/jewelerycategories.html.twig', [
            'categories' => $categoriesRepository->findBy(['name' => array('Bijoux & Montres HOMME','Bijoux & Montres FEMME')])
            ]);
    }


    /* *************** page Notre histoire xiv **************************  */
    #[Route('/UNIVERS-XIV', name: 'app_story')]
    public function indexstory(): Response
    {
        return $this->render('home/story.html.twig');
    }

     /* *************** page sitemap **************************  */
     #[Route('/sitemap', name: 'app_sitemap')]
     public function indexpresent(): Response
     {
         return $this->render('home/sitemap.html.twig');
     }



     /* *************** page privacy  politique de confi **************************  */
     #[Route('/privacy-policy', name: 'app_privacy')]
     public function indexprivacy(): Response
     {
         return $this->render('notice/privacy.html.twig');
     }


     /* *************** page legalnotice  mentions lega **************************  */
     #[Route('/legal', name: 'app_legal')]
     public function indexlegal(): Response
     {
         return $this->render('notice/legalnotice.html.twig');
     }

     /* *************** page CGV  Conditions générales de vente **************************  */
     #[Route('/cgv', name: 'app_cgv')]
     public function indexcgv(): Response
     {
         return $this->render('notice/cgv.html.twig');
     }


}




