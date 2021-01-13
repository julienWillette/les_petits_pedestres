<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SitemapController extends AbstractController
{
    /**
     * @Route("/sitemap.xml", name="sitemap", defaults={"_format"="xml"})
     */
    public function index(Request $request)
    {
        // Nous récupérons le nom d'hôte depuis l'URL
        $hostname = $request->getSchemeAndHttpHost();
        // On initialise un tableau pour lister les URLs
        $urls = [];

        // On ajoute les URLs "statiques"
        $urls[] = ['loc' => $this->generateUrl('home')];
        $urls[] = ['loc' => $this->generateUrl('product')];
        
        // On ajoute les URLs dynamiques des produits dans le tableau
        foreach ($this->getDoctrine()->getRepository(Product::class)->findAll() as $product) {
            // $images = [
            //     'loc' => '/uploads/images/featured/'.$product->getFeaturedImage(), // URL to image
            //     'title' => $product->getTitre()    // Optional, text describing the image
            // ];

            $urls[] = [
                'loc' => $this->generateUrl('product', [
                    'slug' => $product->getSlug(),
                ]),
                // 'lastmod' => $product->getUpdatedAt()->format('Y-m-d'),
                // 'image' => $images
            ];
        }

        $response = new Response(
            $this->renderView('sitemap/index.html.twig', ['urls' => $urls,
                'hostname' => $hostname]),
            200
        );
        
        // Ajout des entêtes
        // $response->headers->set('Content-Type', 'text/xml');
        
        // On envoie la réponse
        return $response;
    }
}