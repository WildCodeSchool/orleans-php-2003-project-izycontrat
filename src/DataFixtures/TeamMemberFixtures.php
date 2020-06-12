<?php

namespace App\DataFixtures;

use App\Entity\TeamMember;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TeamMemberFixtures extends Fixture
{
    const NB_MEMBERS = 6;

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < self::NB_MEMBERS; $i++) {
            $teamMember = new TeamMember();
            $teamMember->setName($faker->name());
            $teamMember->setRole(ucfirst(implode(' ', $faker->words())));
            $teamMember->setDescription($faker->realText());
            $teamMember->setPicture('https://via.placeholder.com/500x1000');
            if (rand(0, 1)) {
                $teamMember->setSocialLink('https://www.linkedin.com/');
            }

            $manager->persist($teamMember);
        }

        $manager->flush();
    }
}
