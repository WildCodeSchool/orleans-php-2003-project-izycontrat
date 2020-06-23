<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ArticleFixtures extends Fixture
{
    const NB_POSTS = 5;

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < self::NB_POSTS; $i++) {
            $article = new Article();
            $article->setDate($faker->dateTimeThisDecade());
            $article->setLawyer($faker->name());
            $article->setTitle($faker->sentence(rand(1, 5)));
            $article->setText($faker->realText(100));
            if (rand(0, 1)) {
                $article->setImage('https://via.placeholder.com/' . rand(500, 2000) . 'x' . rand(500, 2000));
            }

            $manager->persist($article);
        }

        $manager->flush();
    }
}
