<?php

namespace App\Controller;

use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SitemapxmlController extends AbstractController
{
    #[Route('/sitemap.xml', name: 'app_sitemapxml', defaults: ['_format' => 'xml'])]
    public function index(Request $request, ProductsRepository $productsRepository): Response
    {

        $hostname = $request->getSchemeAndHttpHost();

        $urls = [];

        $urls[] = ['loc' => $this->generateUrl('home.index')];
        $urls[] = ['loc' => $this->generateUrl('app_mencategories')];
        $urls[] = ['loc' => $this->generateUrl('app_womencategories')];
        $urls[] = ['loc' => $this->generateUrl('app_childrencategories')];
        $urls[] = ['loc' => $this->generateUrl('app_jewelerycategories')];
        $urls[] = ['loc' => $this->generateUrl('app_story')];
        $urls[] = ['loc' => $this->generateUrl('app_sitemap')];
        $urls[] = ['loc' => $this->generateUrl('app_contact')];

        foreach ($productsRepository->findAll() as $produit) {
          $urls[] = [
                 'loc' => $this->generateUrl('categories_list', ['slug' => $produit->getSlug()]), 
                 'lastmod' => $produit->getDate()->format('Y-m-d')
          ]; 

        }
        
        $response = new Response(
            $this->renderView('sitemapxml/index.html.twig', [
                'urls'     => $urls,
                'hostname' => $hostname,
            ]),
            200
        );

        $response->headers->set('Content-type', 'text/xml');
       


        return $response;
    }

}
