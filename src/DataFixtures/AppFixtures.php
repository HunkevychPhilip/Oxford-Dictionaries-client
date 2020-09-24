<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Searches;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 150; $i++) {
            $searchResult = new Searches();
            $searchResult->setTitle($faker->word(15));
            $searchResult->setSearched($faker->randomDigit);
            $manager->persist($searchResult);
        }
        
        $manager->flush();
    }
}
