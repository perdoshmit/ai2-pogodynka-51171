<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 2)]
    private ?string $country = null;

    /**
     * @var Collection<int, WeatherConditions>
     */
    #[ORM\OneToMany(targetEntity: WeatherConditions::class, mappedBy: 'location')]
    private Collection $weatherConditions;

    public function __construct()
    {
        $this->weatherConditions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection<int, WeatherConditions>
     */
    public function getWeatherConditions(): Collection
    {
        return $this->weatherConditions;
    }

    public function addWeatherCondition(WeatherConditions $weatherCondition): static
    {
        if (!$this->weatherConditions->contains($weatherCondition)) {
            $this->weatherConditions->add($weatherCondition);
            $weatherCondition->setLocation($this);
        }

        return $this;
    }

    public function removeWeatherCondition(WeatherConditions $weatherCondition): static
    {
        if ($this->weatherConditions->removeElement($weatherCondition)) {
            // set the owning side to null (unless already changed)
            if ($weatherCondition->getLocation() === $this) {
                $weatherCondition->setLocation(null);
            }
        }

        return $this;
    }
}
