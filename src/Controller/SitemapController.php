<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SitemapController extends AbstractController
{
    // #[Route('/sitemap', name: 'sitemap', defaults: {"_format"="xml"})]

    /**
     * @Route("/sitemap.xml", name="sitemap", defaults={"_format"="xml"})
     *
     * @return Response
     */
    public function index(Request $request): Response
    {
        $hostname = $request->getSchemeAndHttpHost();
        
        $url = [];

        $url[] = ['loc'=>$this->generateUrl('home')];
        $url[] = ['loc'=>$this->generateUrl('realisations')];
        $url[] = ['loc'=>$this->generateUrl('contact')];


        dd($url);
        return $this->render('sitemap/index.html.twig', [
            'controller_name' => 'SitemapController',
        ]);
    }
}
