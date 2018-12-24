<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="FlagRepository")
 */
class Flag
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\WorkDay", inversedBy="flags")
     * @ORM\JoinColumn(nullable=false)
     */
    private $workDay;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $comment;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="boolean")
     */
    private $viewed;

    public function __construct()
    {
        $this->setDate(new \DateTime());
        $this->setViewed(0);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWorkDay(): ?WorkDay
    {
        return $this->workDay;
    }

    public function setWorkDay(?WorkDay $workDay): self
    {
        $this->workDay = $workDay;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
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

    public function getViewed(): ?bool
    {
        return $this->viewed;
    }

    public function setViewed(bool $viewed): self
    {
        $this->viewed = $viewed;

        return $this;
    }

    public function __toString()
    {
        return $this->getDate()->format('d-M-Y').'-'.substr($this->getComment(),0,25);
    }
}
