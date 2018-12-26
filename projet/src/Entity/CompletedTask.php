<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompletedTaskRepository")
 */
class CompletedTask
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="time")
     */
    private $duration;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Task", inversedBy="completedTasks")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $task;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Worker", inversedBy="completedTasks")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $worker;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\WorkDay")
     * @ORM\JoinColumn(nullable=false)
     */
    private $workday;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDuration(): ?\DateTimeInterface
    {
        return $this->duration;
    }

    public function setDuration(\DateTimeInterface $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getTask(): ?Task
    {
        return $this->task;
    }

    public function setTask(?Task $task): self
    {
        $this->task = $task;

        return $this;
    }

    public function getWorker(): ?Worker
    {
        return $this->worker;
    }

    public function setWorker(?Worker $worker): self
    {
        $this->worker = $worker;

        return $this;
    }
    public function __toString()
    {
        return 'CT'.$this->getTask().'-'.$this->getWorker();
    }

    public function getWorkday(): ?WorkDay
    {
        return $this->workday;
    }

    public function setWorkday(?WorkDay $workday): self
    {
        $this->workday = $workday;

        return $this;
    }
}
