<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\DataFixtures\UsersFixture;

use App\Entity\Task;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
Use Faker\Factory;

class TasksFixture extends Fixture implements DependentFixtureInterface
{

    private const TASKS_NUMBER = 10;

    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        // create tesks
        for ($i = 0; $i < self::TASKS_NUMBER; $i++) {
            $task = new Task();
            $task->setTitle($this->faker->sentence());
            $task->setContent($this->faker->text());
            $task->setCreator($this->getReference(UsersFixture::USER_REFERENCES[array_rand(UsersFixture::USER_REFERENCES)]));
            $manager->persist($task);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UsersFixture::class,
        ];
    }
}
