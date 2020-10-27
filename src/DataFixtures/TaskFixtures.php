<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use function sprintf;

final class TaskFixtures extends Fixture
{
    protected const TASK_QUANTITY = 5;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= self::TASK_QUANTITY; $i++) {
            $task = (new Task())
                ->setTitle(sprintf('Sample task %d', $i))
                ->setDescription('I\'m a description');

            $manager->persist($task);
        }

        $manager->flush();
    }
}
