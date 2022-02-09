<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            [
                'name' => 'iPhone 13 Pro',
                'price' => 21499.00,
                'status' => 'active',
            ],
            [
                'name' => 'iPhone 13',
                'price' => 14799.99,
                'status' => 'active',
            ],
            [
                'name' => 'iPhone 12',
                'price' => 13499.50,
                'status' => 'active',
            ],
            [
                'name' => 'iPhone SE',
                'price' => 12000.00,
                'status' => 'active',
            ],
            [
                'name' => 'iPhone 11',
                'price' => 11200.90,
                'status' => 'active',
            ],
            [
                'name' => 'iPhone 8',
                'price' => 8000.99,
                'status' => 'inactive',
            ],
            [
                'name' => 'iPhone 7',
                'price' => 5000.99,
                'status' => 'inactive',
            ]
        ];

        foreach ($data as $item) {
            $product = new Product();
            $product->setName($item['name']);
            $product->setPrice($item['price']);
            $product->setStatus($item['status']);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
