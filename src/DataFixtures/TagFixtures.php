<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TagFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create("fr_FR");
        for ($i = 0; $i < 20; $i++) {
            $tag = new Tag();
            $tag->setName($faker->word());
            $tag->setCreatedAt($faker->dateTime);
            $manager->persist($tag);
        }

        $manager->flush();
    }
}
