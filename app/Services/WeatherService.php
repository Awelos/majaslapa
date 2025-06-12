<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    public function getCurrentWeather(string $city = 'Riga', string $country = 'LV')
    {
        $apiKey = config('services.openweather.key');

        $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
            'q'     => "$city,$country",
            'appid' => $apiKey,
            'units' => 'metric',
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }
}
