<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Location;
use App\Repository\LocationRepository;
use App\Repository\WeatherConditionsRepository;

class WeatherUtil
{

    private WeatherConditionsRepository $weatherConditionsRepository;
    private LocationRepository $locationRepository;
    public function __construct(WeatherConditionsRepository $weatherConditionsRepository, LocationRepository $locationRepository)
    {
        $this->weatherConditionsRepository = $weatherConditionsRepository;
        $this->locationRepository = $locationRepository;
    }
    /**
     * @return Measurement[]
     */
    public function getWeatherForLocation(Location $location): array
    {
        return $this->weatherConditionsRepository->findByLocation($location);
    }

    /**
     * @return Measurement[]
     */
    public function getWeatherForCountryAndCity( string $city, ?string $countryCode=null): array
    {
        $locations = $this->locationRepository->findByCityAndCountry($city, $countryCode);

        if (empty($locations)) {
            throw new \Exception('Location not found');
        }

        return $this->getWeatherForLocation($locations[0]);
    }
}