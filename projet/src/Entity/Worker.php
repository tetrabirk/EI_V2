<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;


/**
 * @ORM\Entity(repositoryClass="App\Repository\WorkerRepository")
 */
class Worker extends User
{

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CompletedTask", mappedBy="worker")
     */
    private $completedTasks;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\WorkDay", inversedBy="workers")
     * @ORM\JoinTable(name="workDays")
     */
    private $workDays;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\WorkDay", mappedBy="author", cascade={"remove"})
     */
    private $redactedWorkDays;

    public function __construct()
    {
        $this->completedTasks = new ArrayCollection();
        $this->workDays = new ArrayCollection();
        $this->redactedWorkDays = new ArrayCollection();
        $this->setActive(1);
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
    public function getWorkDays(): Collection
    {
        return $this->workDays;
    }

    public function addWorkDay(WorkDay $workDay): self
    {
        if (!$this->workDays->contains($workDay)) {
            $this->workDays[] = $workDay;
        }

        return $this;
    }

    public function removeWorkDay(WorkDay $workDay): self
    {
        if ($this->workDays->contains($workDay)) {
            $this->workDays->removeElement($workDay);
        }

        return $this;
    }

    /**
     * @return Collection|WorkDay[]
     */
    public function getRedactedWorkDays(): Collection
    {
        return $this->redactedWorkDays;
    }

    public function addRedactedWorkDay(WorkDay $redactedWorkDay): self
    {
        if (!$this->redactedWorkDays->contains($redactedWorkDay)) {
            $this->redactedWorkDays[] = $redactedWorkDay;
            $redactedWorkDay->setAuthor($this);
        }

        return $this;
    }

    public function removeRedactedWorkDay(WorkDay $redactedWorkDay): self
    {
        if ($this->redactedWorkDays->contains($redactedWorkDay)) {
            $this->redactedWorkDays->removeElement($redactedWorkDay);
            // set the owning side to null (unless already changed)
            if ($redactedWorkDay->getAuthor() === $this) {
                $redactedWorkDay->setAuthor(null);
            }
        }

        return $this;
    }

}
