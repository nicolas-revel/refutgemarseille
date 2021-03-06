<?php

namespace App\DataFixtures;

use App\Form\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create("fr_FR");
        for ($i = 0; $i <20; $i++) {
            $category = new Category();
            $category->setName($faker->word());
            $category->setImage($faker->image());
            $category->setCreatedAt($faker->dateTime);
            $category->setUpdatedAt($faker->dateTime);
            $manager->persist($category);
        }

        $manager->flush();
    }
}
