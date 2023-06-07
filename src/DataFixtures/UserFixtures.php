<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->userPasswordHasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        // Création de 5 utilisateurs de type "user"
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setNom($faker->name);
            $user->setEmail($faker->email);
            $plainPassword = $faker->password();
            $hashedPassword = $this->userPasswordHasher->hashPassword(
                $user,
                $plainPassword
            );
            $user->setPassword($hashedPassword);
            $user->setRoles(['ROLE_USER']);
            $manager->persist($user);
        }

        // Création d'un utilisateur de type "admin" avec le mot de passe "admin" et le rôle "ROLE_ADMIN" et l'email "admin@gmail"
        $admin = new User();
        $admin->setNom($faker->name);
        $admin->setEmail("admin@gmail.com");
        $plainPassword = "admin";
        $hashedPassword = $this->userPasswordHasher->hashPassword(
            $admin,
            $plainPassword
        );
        $admin->setPassword($hashedPassword);
        $admin->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        $manager->persist($admin);
        $manager->flush();
        

    }
}
