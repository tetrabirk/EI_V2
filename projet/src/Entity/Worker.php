<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WorkerRepository")
 */
class Worker extends User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CompletedTask", mappedBy="worker")
     */
    private $completedTasks;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\WorkDay", inversedBy="workers")
     */
    private $workDay;

    public function __construct()
    {
        $this->completedTasks = new ArrayCollection();
        $this->workDay = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $completedTask->setWorker($this);
        }

        return $this;
    }

    public function removeCompletedTask(CompletedTask $completedTask): self
    {
        if ($this->completedTasks->contains($completedTask)) {
            $this->completedTasks->removeElement($completedTask);
            // set the owning side to null (unless already changed)
            if ($completedTask->getWorker() === $this) {
                $completedTask->setWorker(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|WorkDay[]
     */
    public function getWorkDay(): Collection
    {
        return $this->workDay;
    }

    public function addWorkDay(WorkDay $workDay): self
    {
        if (!$this->workDay->contains($workDay)) {
            $this->workDay[] = $workDay;
        }

        return $this;
    }

    public function removeWorkDay(WorkDay $workDay): self
    {
        if ($this->workDay->contains($workDay)) {
            $this->workDay->removeElement($workDay);
        }

        return $this;
    }
}
