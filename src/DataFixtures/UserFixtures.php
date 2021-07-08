<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function load (ObjectManager $manager)
    {
        $faker = Factory::create("fr_FR");
        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setEmail($faker->email);
            $user->setPassword($faker->password);
            $user->setRoles($faker->shuffleArray(["ROLE_USER", "ROLE_ADMIN"]));
            $user->setIsVerified($faker->boolean);
            $user->setFirstname($faker->firstName);
            $user->setLastname($faker->lastName);
            $user->setPhoneNumber($faker->phoneNumber);
            $user->setCreatedAt($faker->dateTime);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
