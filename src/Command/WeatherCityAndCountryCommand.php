<?php

namespace App\Command;

use App\Repository\LocationRepository;
use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'weather:city-and-country',
    description: 'Get weather information for a specific city and country code.',
)]
class WeatherCityAndCountryCommand extends Command
{
    private LocationRepository $locationRepository;
    private WeatherUtil $weatherUtil;

    public function __construct(LocationRepository $locationRepository, WeatherUtil $weatherUtil)
    {
        parent::__construct();
        $this->locationRepository = $locationRepository;
        $this->weatherUtil = $weatherUtil;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('city', InputArgument::REQUIRED, 'City name')
            ->addArgument('countryCode', InputArgument::REQUIRED, 'Country code');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $city = $input->getArgument('city');
        $countryCode = $input->getArgument('countryCode');

        $locations = $this->locationRepository->findByCityAndCountry($city, $countryCode);

        if (empty($locations)) {
            $io->error('Location not found.');
            return Command::FAILURE;
        }

        $measurements = $this->weatherUtil->getWeatherForLocation($locations[0]);
        $io->writeln(sprintf('Location: %s, %s', $locations[0]->getCity(), $countryCode));

        foreach ($measurements as $measurement) {
            $io->writeln(sprintf("\t%s: %s",
                $measurement->getDate()->format('Y-m-d'),
                $measurement->getCelsius()
            ));
        }

        return Command::SUCCESS;
    }
}
