<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\API\WeatherService;

class WeatherController extends Controller
{
    public function __construct(
        private WeatherService $weatherService
    ) {}

    public function getWeatherByCity(string $city) {
        return $this->weatherService->getWeatherByCity($city);
    }
}
