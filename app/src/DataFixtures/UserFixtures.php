<?php
/**
 * This file is part of the Wallet project.
 *
 * (c) Martyna Szymańska martyna.81.szymanska@student.uj.edu.pl
 */

namespace App\DataFixtures;

use App\Entity\Enum\UserRole;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Class UserFixtures.
 *
 * Loads user data fixtures into the database.
 */
class UserFixtures extends Fixture
{
    /**
     * UserFixtures constructor and password hasher service.
     *
     * @param UserPasswordHasherInterface $passwordHasher the password hasher service
     */
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    /**
     * Load user data fixtures.
     *
     * @param ObjectManager $manager the object manager
     */
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('admin@example.com');
        $user->setRoles([UserRole::ROLE_USER->value, UserRole::ROLE_ADMIN->value]);
        $user->setPassword(
            $this->passwordHasher->hashPassword(
                $user,
                'admin1234'
            )
        );
        $manager->persist($user);
        $manager->flush();
    }
}
