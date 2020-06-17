<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

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
            $blogPost = new Article();
            $blogPost->setCreatedAt($faker->dateTimeThisDecade());
            //$blogPost->setLawyer($faker->name());
            $blogPost->setTitle($faker->sentence(rand(1, 5)));
            $blogPost->setText($faker->realText(1000));
            if (rand(0, 1)) {
                $blogPost->setImage('https://via.placeholder.com/' . rand(500, 2000) . 'x' . rand(500, 2000));
            }
            $blogPost->setCreatedBy($this->getReference('user_1'));
            $manager->persist($blogPost);
        }

        $manager->flush();
    }
}
