<?php

namespace App\Controller;


use App\Repository\LocationRepository;

use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WeatherController extends AbstractController
{
    #[Route('/weather/{city}/{country?}', name: 'app_weather_city')]
    public function city(string $city, ?string $country, LocationRepository $locationRepository, WeatherUtil $util): Response
    {


        $location = $locationRepository->findByCityAndCountry($city, $country);

        if (!$location) {
            throw $this->createNotFoundException('Location not found');
        }
        $location = $location[0];

        $measurements = $util->getWeatherForCountryAndCity($city, $country);

        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'measurements' => $measurements,
        ]);
    }
}