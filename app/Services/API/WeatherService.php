<?php

namespace App\Services\API;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class WeatherService
{
    private const GEO_API_URI = "http://api.openweathermap.org/geo/1.0/direct";
    private const WEATHER_API_URI = "https://api.openweathermap.org/data/2.5/weather";
    private const WEATHER_TTL = 60;

    public function getWeatherByCity(string $city) {
        if (cache()->has("weather_" . $city)) {
            return cache()->get("weather_" . $city);
        }

        $geoResponse = $this->requestFirstFoundGeoDataByCity($city);
        $weatherResponse = $this->requestWeatherDataByCoordinates($geoResponse["lon"], $geoResponse["lat"]);

        cache()->put("weather_" . $city, $weatherResponse, self::WEATHER_TTL);
        return $weatherResponse;
    }


    private function requestFirstFoundGeoDataByCity(string $city): array
    {
        $response = Http::get(self::GEO_API_URI, [
            "q"=> $city,
            "appid" => env("WEATHER_API_KEY", "none")
        ]);

        $this->verifyResponseIsValid($response);
        return $response->json(0);
    }

    private function requestWeatherDataByCoordinates(float $lon, float $lat) {
        $response = Http::get(self::WEATHER_API_URI, [
            "lat"=> $lat,
            "lon"=> $lon,
            "appid" => env("WEATHER_API_KEY", "none")
        ]);

        $this->verifyResponseIsValid($response);
        return $response->json();
    }

    private function verifyResponseIsValid(Response $response): void
    {
        if ($response->failed()) {
            $error = $response->json();
            $errorMessage = array_key_exists("message", $error) ? $error["message"] : "Unknown error";
            $errorCode = array_key_exists("cod", $error) ? $error["cod"] : 500;
            response(["message" => $errorMessage], $errorCode);
            return;
        }

        if (empty($response->json())) {
            response(["message" => "City not found."], 404);
        }
    }

}
