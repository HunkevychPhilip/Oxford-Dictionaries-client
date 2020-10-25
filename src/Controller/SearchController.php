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

        if (isset($searchForm['word'])) {
            $dictionary->setWord($searchForm['word']);
        } else {
            throw new InvalidArgumentException('It looks like you didn\'t fill the \'word\' field!!');
        }

        if (isset($searchForm['language'])) {
            $dictionary->setLanguage($searchForm['language']);
        } else {
            throw new InvalidArgumentException('\'language\' field is missing!');
        }

        if (isset($searchForm['fields'])) {
            $dictionary->setFields($searchForm['fields']);
        } else {
            $dictionary->setFields(['definitions']);
        }

        $dictionary->setStrictMatch(false);

        $results = $dictionary->entries();

        // $entityManager = $this->getDoctrine()->getManager();
        $word = $dictionary->getWord();
    //    $existingTitle = $entityManager->getRepository(Searches::class)->findBy(array('title' => $word));

    //    if (empty($existingTitle)) {
    //        $exists = false;
    //    } else {
    //        $exists = true;
    //        $id =  $existingTitle[0]->getId();
    //        $existingQuerys = $entityManager->getRepository(Searches::class)->find($id);
    //    }

    //    if ($exists === false) {
    //        $saveSearch = new Searches();
    //        $saveSearch->setTitle($word);
    //        $saveSearch->setSearched(1);
    //        $entityManager->persist($saveSearch);
    //    } else {
    //        $existingQuerys->setSearched($existingQuerys->getSearched() + 1);
    //    }

    //    $entityManager->flush();

        return $this->render('main/search.html.twig', [
            'word' => $dictionary->getWord(),
            'results' => $results,
        ]);
    }
}
