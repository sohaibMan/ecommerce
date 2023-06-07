<?php

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use Faker;
use App\Entity\Product;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        $imagess = ['fruits-1.jpg', 'fruits-2.jpg', 'fruits-3.jpg', 'fruits-4.jpg', 'legum-3.jpg', 'legum-4.jpg',  'legum-9.jpg',  'fruits-5.jpg', 'legum-6.jpg'];


        for ($i = 0; $i < 50; $i++) {
            $product = new Product();
            $product->setNom($faker->words(2, true));
            $product->setPrix($faker->randomFloat(2, 100, 999));
            $product->setSlug($faker->slug());
            $product->setCreatedAt($faker->dateTime());
            $product->setOnline(true);
            $product->setImage($faker->randomElement($imagess));
            $product->setDescription($faker->text(100));
            $product->setSousTitre($faker->sentence());
            $product->setCategory($this->getReference('category-' . $faker->numberBetween(1, 4)));
            $manager->persist($product);
        }

        $manager->flush();
    }
}
