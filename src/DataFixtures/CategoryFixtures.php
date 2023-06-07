<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $categoryProduits  = [
            1 => [
                'nom' => 'Legumes',
                'slug' => 'Legumes',
            ],
            2 => [
                'nom' => 'Epicerie',
                'slug' => 'Epicerie',
            ],

            3 => [
                'nom' => 'Fruits',
                'slug' => 'Fruits',
            ],

            4 => [
                'nom' => 'Boissons',
                'slug' => 'Boissons',
            ],

        ];

        foreach ($categoryProduits as $key => $value) {
            $category = new Category();
            $category->setNom($value['nom']);
            $category->setSlug($value['slug']);
            $manager->persist($category);
            $this->addReference('category-' . $key, $category);
        }
        $manager->flush();
    }
}
