<?php

namespace App\Entity;

use App\Repository\WeatherConditionsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WeatherConditionsRepository::class)]
class WeatherConditions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'weatherConditions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Location $location = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: 0)]
    private ?string $celsius = null;

    #[ORM\Column]
    private ?bool $is_rain = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: 0)]
    private ?string $rain_predict = null;

    #[ORM\Column]
    private ?bool $wind = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: 0)]
    private ?string $wind_power = null;

    #[ORM\Column(length: 255)]
    private ?string $wind_direction = null;

    #[ORM\Column(length: 255)]
    private ?string $conditions = null;

    #[ORM\Column(length: 255)]
    private ?string $humidity = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getCelsius(): ?string
    {
        return $this->celsius;
    }

    public function setCelsius(string $celsius): static
    {
        $this->celsius = $celsius;

        return $this;
    }

    public function isRain(): ?bool
    {
        return $this->is_rain;
    }

    public function setRain(bool $is_rain): static
    {
        $this->is_rain = $is_rain;

        return $this;
    }

    public function getRainPredict(): ?string
    {
        return $this->rain_predict;
    }

    public function setRainPredict(string $rain_predict): static
    {
        $this->rain_predict = $rain_predict;

        return $this;
    }

    public function isWind(): ?bool
    {
        return $this->wind;
    }

    public function setWind(bool $wind): static
    {
        $this->wind = $wind;

        return $this;
    }

    public function getWindPower(): ?string
    {
        return $this->wind_power;
    }

    public function setWindPower(string $wind_power): static
    {
        $this->wind_power = $wind_power;

        return $this;
    }

    public function getWindDirection(): ?string
    {
        return $this->wind_direction;
    }

    public function setWindDirection(string $wind_direction): static
    {
        $this->wind_direction = $wind_direction;

        return $this;
    }

    public function getConditions(): ?string
    {
        return $this->conditions;
    }

    public function setConditions(string $conditions): static
    {
        $this->conditions = $conditions;

        return $this;
    }

    public function getHumidity(): ?string
    {
        return $this->humidity;
    }

    public function setHumidity(string $humidity): static
    {
        $this->humidity = $humidity;

        return $this;
    }
}
