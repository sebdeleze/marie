<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_default_index')]
    public function index(): Response
    {
        return $this->render('default/index.html.twig');
    }

    #[Route('/a-propos-de-moi', name: 'app_default_about')]
    public function about(): Response
    {
        return $this->render('default/about.html.twig');
    }

    #[Route('/mon-parcours', name: 'app_default_course')]
    public function course(): Response
    {
        return $this->render('default/course.html.twig');
    }

    #[Route('/actualites', name: 'app_default_news')]
    public function news(): Response
    {
        return $this->render('default/news.html.twig');
    }

    #[Route('/mes-sponsors', name: 'app_default_sponsors')]
    public function sponsors(): Response
    {
        return $this->render('default/sponsors.html.twig');
    }

    #[Route('/j-ai-besoin-de-vous', name: 'app_default_help')]
    public function help(): Response
    {
        return $this->render('default/help.html.twig');
    }

    #[Route('/liens-utiles', name: 'app_default_links')]
    public function links(): Response
    {
        return $this->render('default/links.html.twig');
    }
}
