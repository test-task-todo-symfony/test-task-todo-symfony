<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Task;
use App\Exception\Task\TaskNotFoundException;
use App\Service\TaskServiceInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Psr\Log\LoggerInterface;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class TasksController extends AbstractController
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * @var TaskServiceInterface
     */
    private TaskServiceInterface $taskService;

    /**
     * @param LoggerInterface $logger
     * @param SerializerInterface $serializer
     * @param TaskServiceInterface $taskService
     */
    public function __construct(
        LoggerInterface $logger,
        SerializerInterface $serializer,
        TaskServiceInterface $taskService
    ) {
        $this->logger = $logger;
        $this->serializer = $serializer;
        $this->taskService = $taskService;
    }

    /**
     * @Route("/task", methods={"GET"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Task::class))
     *     )
     * )
     * @SWG\Tag(name="tasks")
     *
     * @return JsonResponse
     */
    public function getAction(): JsonResponse
    {
        return $this->json(
            $this->taskService->getList(),
            Response::HTTP_OK
        );
    }

    /**
     * @Route("/task", methods={"POST"})
     *
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     required=true,
     *     description="Task details",
     *     @Model(type=Task::class, groups={"details"})
     * )
     * @SWG\Response(
     *     response=200,
     *     description="",
     *     @Model(type=Task::class)
     * )
     * @SWG\Tag(name="tasks")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function createAction(Request $request): JsonResponse
    {
        /** @var Task $task */
        $task = $this->serializer->deserialize($request->getContent(), Task::class, 'json');

        $this->taskService->save($task);

        return $this->json($task);
    }

    /**
     * @Route("/task/{id}", methods={"GET"})
     *
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="integer",
     *     description="Task identifier"
     * )
     * @SWG\Response(
     *     response=200,
     *     description="",
     *     @Model(type=Task::class)
     * )
     * @SWG\Response(
     *     response=404,
     *     description="Task not found"
     * )
     * @SWG\Tag(name="tasks")
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function getByIdAction(int $id): JsonResponse
    {
        try {
            $task = $this->taskService->getTaskById($id);
        } catch (TaskNotFoundException $exception) {
            $this->logger->error($exception->getMessage());

            return $this->json([], Response::HTTP_NOT_FOUND);
        }

        return $this->json($task);
    }

    /**
     * @Route("/task/{id}", methods={"DELETE"})
     *
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="integer",
     *     description="Task identifier"
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Record is deleted"
     * )
     * @SWG\Response(
     *     response=404,
     *     description="Record does not exist or has been deleted"
     * )
     * @SWG\Tag(name="tasks")
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function deleteByIdAction(int $id): JsonResponse
    {
        try {
            $this->taskService->deleteById($id);
        } catch (TaskNotFoundException $exception) {
            $this->logger->error($exception->getMessage());

            return $this->json([], Response::HTTP_NOT_FOUND);
        }

        return $this->json([]);
    }
}
