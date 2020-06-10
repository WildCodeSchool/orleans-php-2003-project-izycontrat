<?php


namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $faker  =  Faker\Factory::create('fr_FR');
        for ($i=1; $i<=50; $i++) {
            $user->setEmail($faker->email);
            $user->setPassword($faker->word);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'password'
            ));
            $user->setRoles(['ROLE_USER']);
            $manager->persist($user);
        }
        for ($i=1; $i<=1; $i++) {
            $user->setEmail($faker->email);
            $user->setPassword($faker->word);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'password'
            ));
            $user->setRoles(['ROLE_ADMIN']);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
