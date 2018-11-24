<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 */
class Task
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Site", inversedBy="tasks")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $site;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CompletedTask", mappedBy="task")
     */
    private $completedTasks;

    public function __construct()
    {
        $this->completedTasks = new ArrayCollection();
    }

    /**
     * @return Collection|CompletedTask[]
     */
    public function getCompletedTasks(): Collection
    {
        return $this->completedTasks;
    }

    public function addCompletedTask(CompletedTask $completedTask): self
    {
        if (!$this->completedTasks->contains($completedTask)) {
            $this->completedTasks[] = $completedTask;
            $completedTask->setTask($this);
        }

        return $this;
    }

    public function removeCompletedTask(CompletedTask $completedTask): self
    {
        if ($this->completedTasks->contains($completedTask)) {
            $this->completedTasks->removeElement($completedTask);
            // set the owning side to null (unless already changed)
            if ($completedTask->getTask() === $this) {
                $completedTask->setTask(null);
            }
        }

        return $this;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSite(): ?Site
    {
        return $this->site;
    }

    public function setSite(?Site $site): self
    {
        $this->site = $site;

        return $this;
    }
}
