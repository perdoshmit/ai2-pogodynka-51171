<?php

namespace App\Tests\Entity;

use App\Entity\WeatherConditions;
use PHPUnit\Framework\TestCase;

class MeasurementTest extends TestCase
{
    public function dataGetFahrenheit(): array
    {
        return [
            [0, 32],
            [-100, -148],
            [100, 212],
            [-18.3, -0.94],
            [45.5, 113.9],
            [8.6, 47.48],
            [27.8, 82.04], [-5.2, 22.64], [60, 140], [-30.7, -23.26]
        ];
    }
    /**
     * @dataProvider dataGetFahrenheit
     */
    public function testGetFahrenheit($celsius, $expectedFahrenheit): void
    {
        $measurement = new WeatherConditions();
        $measurement->setCelsius($celsius);

        $this->assertEquals(round($expectedFahrenheit, 2), round($measurement->getFahrenheit(), 2));
    }
}
