<?php

namespace App\Http\Controllers;

use App\Services\WeatherService;
use App\Helpers\ResponseHelper;

class WeatherController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function getCurrentWeather()
    {
        $weatherData = $this->weatherService->getCurrentWeather();
        return ResponseHelper::create(200, $weatherData, "Weater data fetched successfully");
    }
}