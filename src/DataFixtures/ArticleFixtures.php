<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [UserFixtures::class];
    }

    const NB_POSTS = 5;

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < self::NB_POSTS; $i++) {
            $article = new Article();
            $article->setTitle($faker->sentence(rand(1, 5)));
            $article->setText($faker->realText(100));
            $article->setCreatedAt($faker->dateTimeThisDecade());
            $article->setCreatedBy($this->getReference('user_1'));
            $manager->persist($article);
        }

        $manager->flush();
    }
}
