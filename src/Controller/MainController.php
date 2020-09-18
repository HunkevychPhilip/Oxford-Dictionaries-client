<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route ("/", name="app_homepage")
     */
    public function homepage(): Response
    {
        return $this->render('main/homepage.html.twig');
    }

    /**
     * @Route("/search", name="app_search", methods="GET")
     */
    public function search(): Response
    {
        return $this->render('main/search.html.twig');
    }
}
