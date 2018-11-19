<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WorkDayRepository")
 */
class WorkDay
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Worker", mappedBy="workDays")
     */
    private $workers;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Worker", inversedBy="redactedWorkDays", cascade={"remove"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Site", inversedBy="workDays")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $site;

    public function __construct()
    {
        $this->workers = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return Collection|Worker[]
     */
    public function getWorkers(): Collection
    {
        return $this->workers;
    }

    public function addWorker(Worker $worker): self
    {
        if (!$this->workers->contains($worker)) {
            $this->workers[] = $worker;
            $worker->addWorkDay($this);
        }
        return $this;
    }

    public function removeWorker(Worker $worker): self
    {
        if ($this->workers->contains($worker)) {
            $this->workers->removeElement($worker);
            $worker->removeWorkDay($this);
        }

        return $this;
    }

    public function getAuthor(): ?Worker
    {
        return $this->author;
    }

    public function setAuthor(?Worker $author): self
    {
        $this->author = $author;

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
