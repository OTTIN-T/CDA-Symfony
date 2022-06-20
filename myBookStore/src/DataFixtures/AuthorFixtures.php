<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AuthorFixtures extends Fixture
{

    const DATA = [
        [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'gender' => 'M'
        ],
        [
            'firstname' => 'Jean',
            'lastname' => 'Doe',
            'gender' => 'F'
        ],
        [
            'firstname' => 'AASDfsdf',
            'lastname' => 'FFFFFFSWEA',
            'gender' => 'N'
        ]
    ];
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        foreach (self::DATA as $item) {
            $author = new Author;
            $author->setFirstName($item['firstname']);
            $author->setLastName($item['lastname']);
            $author->setGender($item['gender']);

            $manager->persist($author);
        };
        $manager->flush();
    }
}
