<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SiteRepository")
 */
class Site
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $shortName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $postCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $locality;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=7, nullable=true)
     */
    private $latitude;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=7, nullable=true)
     */
    private $longitude;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Task", mappedBy="site", orphanRemoval=true)
     */
    private $tasks;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\WorkDay", mappedBy="site")
     * @ORM\OrderBy({"date" = "DESC"})
     */
    private $workDays;

    /**
    * @ORM\OneToMany(targetEntity="Participation", mappedBy="site")
    */
    private $participations;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $firstWorkDay;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastWorkDay;

    /**
     * @ORM\Column(type="boolean")
     */
    private $finished;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
        $this->workDays = new ArrayCollection();
        $this->participations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getshortName(): ?string
    {
        return $this->shortName;
    }

    public function setshortName(string $shortName): self
    {
        $this->shortName = $shortName;

        return $this;
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostCode(): ?string
    {
        return $this->postCode;
    }

    public function setPostCode(?string $postCode): self
    {
        $this->postCode = $postCode;

        return $this;
    }

    public function getLocality(): ?string
    {
        return $this->locality;
    }

    public function setLocality(?string $locality): self
    {
        $this->locality = $locality;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->locality = $country;

        return $this;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function setLatitude($latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function setLongitude($longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection|Task[]
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
            $task->setSite($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->contains($task)) {
            $this->tasks->removeElement($task);
            // set the owning side to null (unless already changed)
            if ($task->getSite() === $this) {
                $task->setSite(null);
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
            $workDay->setSite($this);
        }

        return $this;
    }

    public function removeWorkDay(WorkDay $workDay): self
    {
        if ($this->workDays->contains($workDay)) {
            $this->workDays->removeElement($workDay);
            // set the owning side to null (unless already changed)
            if ($workDay->getSite() === $this) {
                $workDay->setSite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Participation[]
     */
    public function getParticipations(): Collection
    {
        return $this->participations;
    }

    public function addParticipation(Participation $participation): self
    {
        if (!$this->participations->contains($participation)) {
            $this->participations[] = $participation;
            $participation->setSite($this);
        }

        return $this;
    }

    public function removeParticipant(Participation $participation): self
    {
        if ($this->participations->contains($participation)) {
            $this->participations->removeElement($participation);
            // set the owning side to null (unless already changed)
            if ($participation->getSite() === $this) {
                $participation->setSite(null);
            }
        }

        return $this;
    }

    public function getfirstWorkDay(): ?\DateTimeInterface
    {
        return $this->firstWorkDay;
    }

    public function setfirstWorkDay(\DateTimeInterface $firstWorkDay): self
    {
        $this->firstWorkDay = $firstWorkDay;

        return $this;
    }

    public function getlastWorkDay(): ?\DateTimeInterface
    {
        return $this->lastWorkDay;
    }

    public function setlastWorkDay(?\DateTimeInterface $lastWorkDay): self
    {
        $this->lastWorkDay = $lastWorkDay;

        return $this;
    }

    public function getFinished(): ?bool
    {
        return $this->finished;
    }

    public function setFinished(bool $finished): self
    {
        $this->finished = $finished;

        return $this;
    }
    public function __toString()
    {
        return $this->getshortName().'-'.$this->getName();
    }
}
