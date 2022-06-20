<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{

    const DATA = [
        [
            'name' => "Roman",
            'description' => null,
            'color' => "#FF9900",
            'illustration' => null
        ],
        [
            'name' => 'Policier',
            'description' => "Lorem ipsum sdfasd x gdfc awefdesgsdf",
            'color' => "#0099FF",
            'illustration' => null
        ],
        [
            'name' => 'Nouvelle',
            'description' => "Lorem ipsum sdfasd x gdfc awefdesgsdf",
            'color' => "#CC00DD",
            'illustration' => null
        ]
    ];

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        foreach (self::DATA as $item) {
            $category = new Category;
            $category->setName($item['name']);
            $category->setDescription($item['description']);
            $category->setColor($item['color']);
            $category->setIllustration($item['illustration']);

            $manager->persist($category);
        };

        $manager->flush();
    }
}
