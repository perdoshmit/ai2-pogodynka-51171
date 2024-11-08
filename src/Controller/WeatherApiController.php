<?php
namespace App\Controller;

namespace App\Controller;

use App\Entity\WeatherConditions;
use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

class WeatherApiController extends AbstractController
{
    private WeatherUtil $weatherUtil;

    public function __construct(WeatherUtil $weatherUtil)
    {
        $this->weatherUtil = $weatherUtil;
    }

    #[Route('/api/v1/weather', name: 'app_weather_api', methods: ['GET'])]
    public function index(
        #[MapQueryParameter] string $city,
        #[MapQueryParameter] ?string $country = null,
        #[MapQueryParameter] string $format = 'json',
        #[MapQueryParameter('twig')] bool $twig = false,
    ): Response
    {
        if ($city) {
            $measurements = $this->weatherUtil->getWeatherForCountryAndCity($city, $country);
        }


        if ($format === 'csv') {
            if($twig){
                return $this->render('weather_api/index.csv.twig', [
                    'city' => $city,
                    'country' => $country,
                    'measurements' =>  array_map(fn(WeatherConditions $m) => [
                        'date' => $m->getDate()->format('Y-m-d'),
                        'celsius' => $m->getCelsius(),
                        'fahrenheit' => $m->getFahrenheit(),
                    ], $measurements),
                ]);
            }else{
                $csvData = [];
                $csvData[] = 'city,country,date,celsius,fahrenheit';
                foreach ($measurements as $m) {
                    $csvData[] = sprintf(
                        '%s,%s,%s,%s,%s',
                        $city,
                        $country,
                        $m->getDate()->format('Y-m-d'),
                        $m->getCelsius(),
                        $m->getFahrenheit()
                    );
                }
            }

            $csvContent = implode("\n", $csvData);

            return new Response(
                $csvContent,
                200,
                [
                    'Content-Type' => 'text/plain',
                ]
            );
        }

        if ($format === 'json') {
            if($twig){
                return $this->render('weather_api/index.json.twig', [
                    'city' => $city,
                    'country' => $country,
                    'measurements' => array_map(fn(WeatherConditions $m) => [
                        'date' => $m->getDate()->format('Y-m-d'),
                        'celsius' => $m->getCelsius(),
                        'fahrenheit' => $m->getFahrenheit(),
                    ], $measurements),
                ]);
            }else{
                return $this->json([
                    'measurements' => array_map(fn(WeatherConditions $m) => [
                        'date' => $m->getDate()->format('Y-m-d'),
                        'celsius' => $m->getCelsius(),
                        'fahrenheit' => $m->getFahrenheit(),
                    ], $measurements),
                ]);
            }
        }
        return $this->json(['incorrect format' => $format]);
    }
}

