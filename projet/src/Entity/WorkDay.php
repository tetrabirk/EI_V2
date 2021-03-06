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
     * @ORM\ManyToMany(targetEntity="App\Entity\Worker", mappedBy="workDays", cascade={"persist"})
     */
    private $workers;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Worker", inversedBy="redactedWorkDays", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Site", inversedBy="workDays",cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $site;

    /**
     * @ORM\Column(type="boolean")
     */
    private $validated;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Flag", mappedBy="workDay", orphanRemoval=true)
     */
    private $flags;

    /**
     * @ORM\Column(type="boolean")
     */
    private $flagged;

    public $currentPlace;

    /**
     * @ORM\Column(type="json_array", nullable=true)
     */
    protected $state;

    public function setState($state)
    {
        $this->state = $state;
    }

    public function getState()
    {
        return $this->state;
    }

    public function __construct()
    {
        $this->workers = new ArrayCollection();
        $this->flags = new ArrayCollection();
        $this->setValidated(0);
        $this->setFlagged(0);
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

    /**
     * @param mixed $workers
     */
    public function setWorkers($workers): void
    {
        foreach ($workers as $worker)
        {
            $this->addWorker($worker);
        }
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

    public function getValidated(): ?bool
    {
        return $this->validated;
    }

    public function setValidated(bool $validated): self
    {
        $this->validated = $validated;

        return $this;
    }

    /**
     * @return Collection|Flag[]
     */
    public function getFlags(): Collection
    {
        return $this->flags;
    }

    public function addFlag(Flag $flag): self
    {
        if (!$this->flags->contains($flag)) {
            $this->flags[] = $flag;
            $flag->setWorkDay($this);
        }

        return $this;
    }

    public function removeFlag(Flag $flag): self
    {
        if ($this->flags->contains($flag)) {
            $this->flags->removeElement($flag);
            // set the owning side to null (unless already changed)
            if ($flag->getWorkDay() === $this) {
                $flag->setWorkDay(null);
            }
        }

        return $this;
    }

    public function getFlagged(): ?bool
    {
        return $this->flagged;
    }

    public function setFlagged(bool $flagged): self
    {
        $this->flagged = $flagged;

        return $this;
    }

    public function __toString()
    {
        return 'WD-'.$this->getDate()->format('d-M-Y').'-'.$this->getSite();
    }
}
