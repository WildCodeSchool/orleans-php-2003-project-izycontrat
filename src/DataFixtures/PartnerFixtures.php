<?php

namespace App\DataFixtures;

use App\Entity\Partner;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class PartnerFixtures extends Fixture
{
    const NB_PARTNERS = 6;

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < self::NB_PARTNERS; $i++) {
            $partner = new Partner();
            $partner->setName($faker->sentence(rand(1, 5)));
            $partner->setLink('https://www.google.com');
            $partner->setPicture('https://via.placeholder.com/' . rand(200, 500) . 'x' . rand(200, 500));
            $manager->persist($partner);
        }

        $manager->flush();
    }
}
