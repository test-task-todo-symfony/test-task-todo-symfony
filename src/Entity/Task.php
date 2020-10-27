<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Swagger\Annotations as SWG;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 */
class Task
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @SWG\Property(description="Task identifier")
     *
     * @var int|null
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @SWG\Property(type="string", maxLength=255, description="Task title")
     * @SWG\Tag(name="details")
     *
     * @Groups({"details"})
     *
     * @var string|null
     */
    private ?string $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @SWG\Property(type="string", description="Task description")
     *
     * @Groups({"details"})
     *
     * @var string|null
     */
    private ?string $description;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     *
     * @return $this
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
