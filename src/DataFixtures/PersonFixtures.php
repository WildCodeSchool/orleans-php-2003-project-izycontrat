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
            if ($genderNumber === 2) {
                $gender = 'female';
            } elseif ($genderNumber === 1) {
                $gender = 'male';
            } else {
                $gender = null;
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
            $user = new User();
            $person->setUser($user->create(
                $email,
                $this->passwordEncoder->encodePassword($user, 'password'),
                null
            ));
            if ($i >= self::MEMBER) {
                $person->setCapitalAmountAdding($faker->numberBetween(1000, 10000));
                $person->setHasCompany(true);
            }
            $manager->persist($user);
            $manager->persist($person);
        }
        $manager->flush();
    }
}
