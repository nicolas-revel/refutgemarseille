<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordHasherInterface
     */
    private $passwordHasher;

    public function __construct (UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load (ObjectManager $manager)
    {
        $user = new User();
        $manager->persist($user);

        $manager->flush();
        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            'the_new_password'
        ));
    }
}
