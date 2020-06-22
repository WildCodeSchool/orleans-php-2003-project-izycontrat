<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Person;
use Faker;

class PersonFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Faker\Factory::create('fr_FR');
        $person = new Person();
        $genderNumber = $faker->numberBetween(min(0), max(2));
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
        $person->setCapitalAmountAdding($faker->numberBetween(1000, 10000));
        if ($person->getMiddleName() !== null) {
            $email =
                $person->getFirstName() .
                $person->getMiddleName() .
                $person->getLastName() . '@' .
                $faker->safeEmailDomain;
        } else {
            $email =
                $person->getFirstName() .
                $person->getLastName() . '@' .
                $faker->safeEmailDomain;
        }

        $user = new User();
        $person->setUser($user->create($email, 'password', null, true));

        $manager->persist($user);
        $manager->persist($person);
        $manager->flush();
    }
}
