<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use App\Helpers\ResponseHelper;

class WeatherService
{
    protected $apiUrl = 'https://api.weatherapi.com/v1/current.json';

    public function getCurrentWeather($location = 'Perth')
    {
        return Cache::remember("weather_$location", now()->addMinutes(15), function () use ($location) {
            $apiKey = env('WEATHERAPI_KEY');
            $response = Http::get($this->apiUrl, [
                'key' => $apiKey,
                'q' => $location,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return ResponseHelper::create($response->status(), null, "Failed to fetch weather data");
        });
    }
}