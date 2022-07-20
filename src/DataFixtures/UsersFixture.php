<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\User;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsersFixture extends Fixture
{
    private const USERS = [
        [
            'username' => 'admin',
            'password' => 'admin',
            'email' => 'admin@admin.com',
            'roles' => ['ROLE_ADMIN'],
        ],
        [
            'username' => 'user',
            'password' => 'user',
            'email' => 'user@user.com',
            'roles' => ['ROLE_USER'],
        ],
        [
            'username' => 'guest',
            'password' => 'guest',
            'email' => 'guest@guest.com',
            'roles' => ['ROLE_USER'],
        ]
    ];

    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::USERS as $userData) {
            $user = new User();
            $user->setUsername($userData['username']);
            $user->setEmail($userData['email']);
            $user->setRoles($userData['roles']);

            $user->setPassword($this->hasher->hashPassword($user, $userData['password']));

            $manager->persist($user);

            $this->addReference($userData['username'], $user);
        }

        $manager->flush();
    }

}
