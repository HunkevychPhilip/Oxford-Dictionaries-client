<?php

namespace App\Controller;

use App\System\v2\Dictionary;
use App\System\Client\GuzzleClient;
use App\System\v2\DictionaryException;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="app_search", methods="GET")
     */
    public function index(): Response
    {
        $request = Request::createFromGlobals();

        $word = strtolower($request->query->get('word'));
        $lang = $request->query->get('language');

        if (empty($word)) {
            header("Location: /?error=you_must_enter_the_word");
            die();
        }

        if (empty($lang)) {
            header("Location: /?error=you_must_choose_language");
            die();
        }

        $dictionary = new Dictionary(
            new GuzzleClient(
                'https://od-api.oxforddictionaries.com/api/v2/',
                'f719c81c',
                'd5e2e338b13634bb11c13d526dd1bfd8'
            ));

        try {
            $results = $dictionary->entries($lang, $word);
        } catch (DictionaryException $e) {
            $error = $e->getMessage();
            header("Location: /?error=$error");
            die();
        }

        return $this->render('main/search.html.twig', [
            'word' => $word,
            'results' => $results,
        ]);
    }
}
