<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class BlogPostFixtures extends Fixture
{
    const NB_POSTS = 5;

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::NB_POSTS; $i++) {
            $blogPost = new BlogPost();
            $blogPost->setDate($faker->dateTimeThisDecade());
            $blogPost->setLawyer($faker->name());
            $blogPost->setTitle($faker->sentence(rand(1, 10)));
            $blogPost->setText($faker->realText(1000));
            if (rand(0, 1)) {
                $blogPost->setImage('https://via.placeholder.com/' . rand(500, 2000) . 'x' . rand(500, 2000));
            }

            $manager->persist($blogPost);
        }

        $manager->flush();
    }
}
