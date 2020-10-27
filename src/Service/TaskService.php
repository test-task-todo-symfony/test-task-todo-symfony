<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Task;
use App\Exception\Task\TaskNotFoundException;
use App\Repository\TaskRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final class TaskService implements TaskServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;

    /**
     * @var TaskRepositoryInterface
     */
    private TaskRepositoryInterface $repository;

    /**
     * @param EntityManagerInterface $manager
     * @param TaskRepositoryInterface $repository
     */
    public function __construct(EntityManagerInterface $manager, TaskRepositoryInterface $repository)
    {
        $this->manager = $manager;
        $this->repository = $repository;
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @param int $id
     * @return Task
     *
     * @throws TaskNotFoundException
     */
    public function getTaskById(int $id): Task
    {
        $task = $this->repository->find($id);

        if ($task === null) {
            throw new TaskNotFoundException('Task not found');
        }

        return $task;
    }

    /**
     * @param Task $task
     *
     * @return $this
     */
    public function save(Task $task): self
    {
        $this->manager->persist($task);
        $this->manager->flush();

        return $this;
    }

    /**
     * @param int $id
     *
     * @throws TaskNotFoundException
     */
    public function deleteById(int $id): void
    {
        $task = $this->getTaskById($id);

        $this->manager->remove($task);
        $this->manager->flush();
    }
}
