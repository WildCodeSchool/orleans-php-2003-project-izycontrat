<?php

namespace App\DataFixtures;

use App\Entity\Field;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FieldFixtures extends Fixture
{
    const FIELDS = [
        'person' => [
            'firstName' => 'Prénom',
            'lastName' => 'Nom',
            'gender' => 'Genre',
            'phoneNumber' => 'Téléphone',
            'address' => 'Adresse',
            'country' => 'Pays',
        ],
        'user' => [
            'email' => 'Email',
        ]];
    public function load(ObjectManager $manager)
    {
        foreach (self::FIELDS as $entity => $data) {
            foreach ($data as $fieldName => $label) {
                $field = new Field();
                $field->setLabel($label);
                $field->setFieldName($fieldName);
                $field->setEntity($entity);
                $manager->persist($field);
            }
        }
        $manager->flush();
    }
}
