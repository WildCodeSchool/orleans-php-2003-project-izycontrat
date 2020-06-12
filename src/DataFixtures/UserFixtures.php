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

    const USERS = [
        'Jane Doe' => [
            'infos' => [
                "jane.doe@gmail.com",
                ['ROLE_USER']
            ]
        ]
    ];



    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        foreach (self::USERS as $infos) {
            $user = new user();
            $user->setEmail(($infos['infos'][0]));
            $user->setRoles(($infos['infos'][1]));
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'password'
            ));
            $manager->persist($user);
        }

        for ($i=1; $i<=50; $i++) {
            $user = new User();
            $faker  =  Faker\Factory::create('fr_FR');
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
        $manager->flush();
    }
}
