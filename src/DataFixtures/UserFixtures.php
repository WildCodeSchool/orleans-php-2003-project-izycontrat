<?php


namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
     private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {

        for ($i=1; $i<=50; $i++) {
            $user = new User();
            $faker  =  Faker\Factory::create('fr_FR');
            $user->setEmail($faker->email);
            $user->setPassword($faker->word);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'password'
            ));
            if ($i>25) {
                $user->setRoles(['ROLE_CLIENT']);
            }
            $manager->persist($user);
        }
        for ($j=1; $j<=1; $j++) {
            $user = new User();
            $faker  =  Faker\Factory::create('fr_FR');
            $user->setEmail($faker->email);
            $user->setPassword($faker->word);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'password'
            ));
            $user->setRoles(['ROLE_ADMIN']);
            $manager->persist($user);
        }
        for ($k=1; $k<=1; $k++) {
            $user = new User();
            $faker  =  Faker\Factory::create('fr_FR');
            $user->setEmail($faker->email);
            $user->setPassword($faker->word);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'password'
            ));
            $user->setRoles(['ROLE_LAWYER']);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
