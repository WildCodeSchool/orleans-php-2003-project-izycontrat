<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Services\RemoveAccents;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Person;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PersonFixtures extends Fixture
{
    const MEMBER = 20;
    const CLIENT = 20;

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i< self::MEMBER + self::CLIENT; $i++) {
            // $product = new Product();
            // $manager->persist($product);
            $faker = Faker\Factory::create('fr_FR');
            $person = new Person();
            $genderNumber = $faker->numberBetween(0, 2);
            $person->setGender($genderNumber);
            $user = new User();
            if ($genderNumber === 2) {
                $gender = 'female';
                $user->setProfilePicture('https://www.top-metiers.fr/wp-content/uploads/2016/01/'.
                    'liste_metier-de-femme.jpg');
            } elseif ($genderNumber === 1) {
                $gender = 'male';
                $user->setProfilePicture('https://gal.img.pmdstatic.net/fit/http.3A.2F.2Fprd2-bone-image.'.
                    '2Es3-website-eu-west-1.2Eamazonaws.2Ecom.2Fgal.2Fvar.2Fgal.2Fstorage.2Fimages.2Fmedia.2Fmultiupl'.
                    'oad_du_10_juillet_2017.2Fcoupedecheveux.2F4118549-1-fre-FR.2Fcoupedecheveux.2Ejpg/480x480/quality'.
                    '/80/coiffures-homme-les-coupes-de-cheveux-tendances-de-l-ete-2017.jpg');
            } else {
                $gender = null;
                $user->setProfilePicture('https://statics.lesinrocks.com/content/thumbs/uploads/2018/07/'.
                    'width-1125-height-612-quality-10/capture-decran-2018-07-06-a-13-03-57.png');
            }
            $person->setFirstName($faker->firstName($gender));
            $rand = rand(1, 100);
            if ($rand < 50) {
                $person->setMiddleName($faker->firstName($gender));
            }
            $person->setLastName($faker->lastName);
            $person->setPhoneNumber($faker->e164PhoneNumber);
            $person->setAddress($faker->address);
            $removeAccents = new RemoveAccents();
            if ($person->getMiddleName() !== null) {
                $email = strtolower($removeAccents->toLower(
                    $person->getFirstName() . '.' .
                    $person->getMiddleName() . '.' .
                    $person->getLastName() . '@' .
                    $faker->safeEmailDomain
                ));
            } else {
                $email = strtolower($removeAccents->toLower(
                    $person->getFirstName() . '.' .
                    $person->getLastName() . '@' .
                    $faker->safeEmailDomain
                ));
            }
            $person->setUser($user->create(
                $email,
                $this->passwordEncoder->encodePassword($user, 'password'),
                null
            ));
            if ($i >= self::MEMBER) {
                $person->setCapitalAmountAdding($faker->numberBetween(1000, 10000));
                $person->setHasCompany(true);
                $user->setRoles(['ROLE_CLIENT']);
            }
            $manager->persist($user);
            $manager->persist($person);
        }
        $manager->flush();
    }
}
