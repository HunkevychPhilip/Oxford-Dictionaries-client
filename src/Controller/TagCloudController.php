<?php

namespace App\Controller;

use App\Entity\Searches;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TagCloudController extends AbstractController
{
    /**
     * @Route("/tagcloud", name="tag_cloud")
     */
    public function index()
    {
        $data = $this->getData();
        return $this->render('tag_cloud/index.html.twig', [
            'controller_name' => 'TagCloudController', 'data' => $data
        ]);
    }
    public function getData()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $searches = $entityManager->getRepository(Searches::class)->findTopHighestSearch();


        // dd($search);

        $data = [];

        $maximum = 0;

        foreach ($searches as $search) {

            $counter = $search['searched'];

            // dd($search);
            $class = '';

            if ($counter > $maximum) $maximum = $counter;


            $percent = floor(($counter / $maximum) * 100);

            if ($percent < 20) {
                $class = 'smallest';
            } elseif ($percent >= 20 and $percent < 40) {
                $class = 'small';
            } elseif ($percent >= 40 and $percent < 60) {
                $class = 'medium';
            } elseif ($percent >= 60 and $percent < 80) {
                $class = 'large';
            } else {
                $class = 'largest';
            }

            array_push($data, ['title' => $search['title'], 'class' => $class]);
        }

        return $data;
    }
}
