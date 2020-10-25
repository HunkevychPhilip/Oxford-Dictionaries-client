<?php

namespace App\Controller;

use App\Service\Dictionary;
use Symfony\Component\String\Exception\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Searches;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="app_search")
     * @param Request $request
     * @param Dictionary $dictionary
     *
     * @return Response
     * @throws \App\Service\DictionaryException
     */
    public function search(Request $request, Dictionary $dictionary): Response
    {
        $searchForm = $request->query->all('search_form');

        $dictionary->setWord($searchForm['word']);
        $dictionary->setLanguage($searchForm['language']);
        $dictionary->setFields($searchForm['fields']);
        $dictionary->setStrictMatch(false);

        $results = $dictionary->entries();

        return $this->render('main/search.html.twig', [
            'word' => $dictionary->getWord(),
            'results' => $results,
        ]);
    }
}
