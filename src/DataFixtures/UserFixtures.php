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
                'jane.doe@gmail.com',
                'https://www.cs.cornell.edu/sites/default/files/styles/'.
                'icon-100x100/public/mru8-profile.jpg?itok=tD3kKqTY',
                ['ROLE_CLIENT']
            ]
        ],
        'Janine Doe' => [
            'infos' => [
                'janine.doe@gmail.com',
                'https://g1dpicorivera.org/wp-content/uploads/2017/04/Diana-WEB.jpg',
                ['ROLE_ADMIN']
            ]
        ],
        'John Doe' => [
            'infos' => [
                'john.doe@gmail.com',
                'https://www.mylan.com/-/media/mylancom/images/leadership/r-coury-july-2019.jpg',
                ['ROLE_LAWYER']
            ]
        ]
    ];

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $refNumber = 0;

        foreach (self::USERS as $infos) {
            $user = new user();
            $user->setEmail(($infos['infos'][0]));
            $user->setProfilePicture(($infos['infos'][1]));
            $user->setRoles(($infos['infos'][2]));
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'password'
            ));
            $this->addReference('person_' . $refNumber, $user);
            $manager->persist($user);
            $refNumber++;
        }
        for ($j = 1; $j <= 1; $j++) {
            $user = new User();
            $faker = Faker\Factory::create('fr_FR');
            $user->setEmail($faker->email);
            $user->setPassword($faker->word);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'password'
            ));
            $user->setRoles(['ROLE_ADMIN']);
            $this->addReference('user_' . $j, $user);
            $manager->persist($user);
        }
        for ($k = 1; $k <= 1; $k++) {
            $user = new User();
            $faker = Faker\Factory::create('fr_FR');
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
