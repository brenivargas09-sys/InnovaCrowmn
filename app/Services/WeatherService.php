<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class WeatherService
{
    private string $apiKey;
    private string $baseUrl = 'https://api.openweathermap.org/data/2.5';

    public function __construct()
    {
        $this->apiKey = SiteSetting::get('weather_api_key', '');
    }

    public function isConfigured(): bool
    {
        return !empty($this->apiKey) && (
            !empty(SiteSetting::get('weather_lat')) || !empty(SiteSetting::get('weather_city'))
        );
    }

    public function getConfig(): array
    {
        return [
            'api_key'  => SiteSetting::get('weather_api_key', ''),
            'city'     => SiteSetting::get('weather_city', ''),
            'state'    => SiteSetting::get('weather_state', ''),
            'country'  => SiteSetting::get('weather_country', ''),
            'lat'      => SiteSetting::get('weather_lat', ''),
            'lon'      => SiteSetting::get('weather_lon', ''),
        ];
    }

    public function getWeather(): ?array
    {
        if (!$this->isConfigured()) {
            return null;
        }

        $cacheKey = 'weather_data';
        $cacheTtl = (int) (SiteSetting::get('weather_cache_minutes', '30') ?: 30);

        $cached = Cache::get($cacheKey);
        if ($cached !== null) {
            return $cached;
        }

        $result = $this->fetchWeather();

        if ($result !== null) {
            Cache::put($cacheKey, $result, $cacheTtl * 60);
        }

        return $result;
    }

    public function forceRefresh(): ?array
    {
        Cache::forget('weather_data');
        return $this->getWeather();
    }

    private function fetchWeather(): ?array
    {
        $params = $this->buildParams();
        if (!$params) {
            return null;
        }

        try {
            $response = Http::timeout(10)
                ->get("{$this->baseUrl}/weather", $params);

            if ($response->failed()) {
                \Log::warning('Weather API error', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                    'params' => collect($params)->except('appid')->toArray(),
                ]);
                return null;
            }

            $data = $response->json();

            return $this->parseResponse($data);
        } catch (\Exception $e) {
            \Log::error('Weather API exception: ' . $e->getMessage());
            return null;
        }
    }

    private function buildParams(): ?array
    {
        $lat = SiteSetting::get('weather_lat');
        $lon = SiteSetting::get('weather_lon');

        if ($lat && $lon) {
            return [
                'lat'   => $lat,
                'lon'   => $lon,
                'appid' => $this->apiKey,
                'units' => 'metric',
                'lang'  => 'es',
            ];
        }

        $city  = SiteSetting::get('weather_city');
        $state = SiteSetting::get('weather_state');
        $country = SiteSetting::get('weather_country');

        if ($city) {
            $q = $city;
            if ($state) $q .= ",{$state}";
            if ($country) $q .= ",{$country}";

            return [
                'q'     => $q,
                'appid' => $this->apiKey,
                'units' => 'metric',
                'lang'  => 'es',
            ];
        }

        return null;
    }

    private function parseResponse(array $data): array
    {
        $weather = $data['weather'][0] ?? [];

        return [
            'temp'          => round($data['main']['temp'] ?? 0, 1),
            'feels_like'    => round($data['main']['feels_like'] ?? 0, 1),
            'temp_min'      => round($data['main']['temp_min'] ?? 0, 1),
            'temp_max'      => round($data['main']['temp_max'] ?? 0, 1),
            'humidity'      => $data['main']['humidity'] ?? 0,
            'pressure'      => $data['main']['pressure'] ?? 0,
            'wind_speed'    => round(($data['wind']['speed'] ?? 0) * 3.6, 1),
            'wind_deg'      => $data['wind']['deg'] ?? 0,
            'description'   => ucfirst($weather['description'] ?? 'Sin datos'),
            'main'          => $weather['main'] ?? '',
            'icon'          => $weather['icon'] ?? '01d',
            'icon_url'      => 'https://openweathermap.org/img/wn/' . ($weather['icon'] ?? '01d') . '@2x.png',
            'visibility'    => round(($data['visibility'] ?? 0) / 1000, 1),
            'clouds'        => $data['clouds']['all'] ?? 0,
            'sunrise'       => isset($data['sys']['sunrise']) ? date('H:i', $data['sys']['sunrise']) : '',
            'sunset'        => isset($data['sys']['sunset']) ? date('H:i', $data['sys']['sunset']) : '',
            'city_name'     => $data['name'] ?? SiteSetting::get('weather_city', ''),
            'country'       => $data['sys']['country'] ?? SiteSetting::get('weather_country', ''),
            'updated_at'    => now()->format('d/m/Y H:i'),
        ];
    }
}
