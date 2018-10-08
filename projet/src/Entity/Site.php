<?php

namespace App\Entity;

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
    private $ShortName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Address;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $PostCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Locality;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $Country;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=7, nullable=true)
     */
    private $Latitude;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=7, nullable=true)
     */
    private $Longitude;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Active;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShortName(): ?string
    {
        return $this->ShortName;
    }

    public function setShortName(string $ShortName): self
    {
        $this->ShortName = $ShortName;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->Address;
    }

    public function setAddress(?string $Address): self
    {
        $this->Address = $Address;

        return $this;
    }

    public function getPostCode(): ?string
    {
        return $this->PostCode;
    }

    public function setPostCode(?string $PostCode): self
    {
        $this->PostCode = $PostCode;

        return $this;
    }

    public function getLocality(): ?string
    {
        return $this->Locality;
    }

    public function setLocality(?string $Locality): self
    {
        $this->Locality = $Locality;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->Country;
    }

    public function setCountry(?string $Country): self
    {
        $this->Country = $Country;

        return $this;
    }

    public function getLatitude()
    {
        return $this->Latitude;
    }

    public function setLatitude($Latitude): self
    {
        $this->Latitude = $Latitude;

        return $this;
    }

    public function getLongitude()
    {
        return $this->Longitude;
    }

    public function setLongitude($Longitude): self
    {
        $this->Longitude = $Longitude;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->Active;
    }

    public function setActive(bool $Active): self
    {
        $this->Active = $Active;

        return $this;
    }
}
