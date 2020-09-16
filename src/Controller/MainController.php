<?php

namespace App\Controller;

use App\System\Client\GuzzleClient;
use App\System\v2\Dictionary;
use App\System\v2\DictionaryException;
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
    public function index(): Response
    {
        $word = 'run';

        $error = null;
        $results = [];

        $dictionary = new Dictionary(new GuzzleClient());

        try {
            $results = $dictionary->entries('en-gb', $word);
        } catch (DictionaryException $e) {
            $error = $e->getMessage();
        }

        dump($results);


        return $this->render('main/search.html.twig', [
            'word' => $word,
            'results' => $results,
            'error' => $error,
        ]);
    }
}
