<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Services\NormalizePhoneNumber;
use App\Services\RemoveAccents;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Person;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PersonFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [UserFixtures::class];
    }

    const PEOPLE = [
        'Jane Doe' => [
            'infos' => [
                'Jane',
                'Doe',
                1,
                '09 10 06 07 08',
                '8 rue Louis Dupas 45000 Orléans'
            ]
        ],
        'Janine Doe' => [
            'infos' => [
                'Jane',
                'Doe',
                1,
                '60 70 80 90 10',
                '8 avenue Louis Dupat 92000 Nanterre'
            ]
        ],
        'John Doe' => [
            'infos' => [
                'John',
                'Doe',
                0,
                '10 09 08 07 06',
                '8 impasse Luis Dupas 10101 Romilly-sur-Seine'
            ]
        ]
    ];


    const MEMBER = 20;
    const CLIENT = 20;

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $refNumber = 0;
        foreach (self::PEOPLE as $infos) {
            $person = new Person();
            $person->setFirstName(($infos['infos'][0]));
            $person->setLastName(($infos['infos'][1]));
            $person->setGender(($infos['infos'][2]));
            $person->setPhoneNumber(($infos['infos'][3]));
            $person->setAddress(($infos['infos'][4]));
            $person->setUser($this->getReference('person_' . $refNumber));
            $manager->persist($person);
            $refNumber++;
        }


        for ($i = 0; $i < self::MEMBER + self::CLIENT; $i++) {
            $person = new Person();
            $user = new User();
            $faker = Faker\Factory::create('fr_FR');
            $fakePersons = [
                ['gender' => null, 'picture' => 'https://statics.lesinrocks.com/content/thumbs/uploads/2018/07/'.
                    'width-1125-height-612-quality-10/capture-decran-2018-07-06-a-13-03-57.png'],
                ['gender' => 'male', 'picture' => 'https://gal.img.pmdstatic.net/fit/http.3A.2F.2Fprd2-bone-image.'.
                    '2Es3-website-eu-west-1.2Eamazonaws.2Ecom.2Fgal.2Fvar.2Fgal.2Fstorage.2Fimages.2Fmedia.2Fmultiupl'.
                    'oad_du_10_juillet_2017.2Fcoupedecheveux.2F4118549-1-fre-FR.2Fcoupedecheveux.2Ejpg/480x480/quality'.
                    '/80/coiffures-homme-les-coupes-de-cheveux-tendances-de-l-ete-2017.jpg'],
                ['gender' => 'female', 'picture' => 'https://www.top-metiers.fr/wp-content/uploads/2016/01/' .
                    'liste_metier-de-femme.jpg']
            ];
            $fakePerson = $faker->randomElement($fakePersons);
            $person->setGender((int)key($fakePerson));
            $user->setProfilePicture($fakePerson['picture']);
            $person->setFirstName($faker->firstName($fakePerson['gender']));
            $person->setLastName($faker->lastName);
            $person->setPhoneNumber($faker->phoneNumber);
            $person->setAddress($faker->address);
            $removeAccents = new RemoveAccents();
            $email = strtolower($removeAccents->toLower(
                $person->getFirstName() . '.' .
                $person->getLastName() . '@' .
                $faker->safeEmailDomain
            ));
            $user->setEmail($email);
            $user->setPassword($this->passwordEncoder->encodePassword($user, 'password'));
            $person->setUser($user);
            if ($i >= self::MEMBER) {
                $person->setCapitalAmountAdding($faker->numberBetween(1000, 10000));
                $person->setHasCompany(true);
                $user->setRoles(['ROLE_CLIENT']);
            } else {
                $person->setScore(rand(0, 400));
                $user->setRoles(['ROLE_LAWYER']);
            }
            $manager->persist($user);
            $manager->persist($person);
        }
        $manager->flush();
    }
}
