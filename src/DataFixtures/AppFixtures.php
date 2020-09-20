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
            $searchresult = new Searches();
            $searchresult->setTitle(
                $faker->word(15)
            );
            $searchresult->setSearched($faker->randomDigit);
            $manager->persist($searchresult);
        
        }

        $manager->flush();
    }
}