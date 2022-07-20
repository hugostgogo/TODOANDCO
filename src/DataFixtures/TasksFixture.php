<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Task;

Use Faker\Factory;

class TasksFixture extends Fixture
{

    private const TASKS_NUMBER = 10;

    private const USERS_REFERENCES = [
        'admin',
        'user',
        'guest',
    ];

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
            $manager->persist($task);
        }

        $manager->flush();
    }
}
