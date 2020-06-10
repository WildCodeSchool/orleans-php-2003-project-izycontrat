<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PartnerFixtures extends Fixture
{
    const NB_PARTNERS = 8;

    public function load(ObjectManager $manager)
    {
        
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
