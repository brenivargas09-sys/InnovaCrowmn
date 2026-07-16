<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteSetting;
use App\Services\WeatherService;

class WeatherController extends Controller
{
    public function __construct(private WeatherService $weather)
    {
    }

    public function config()
    {
        $config = $this->weather->getConfig();
        $weatherData = $this->weather->getWeather();
        return view('panel.weather', compact('config', 'weatherData'));
    }

    public function configUpdate(Request $request)
    {
        $validated = $request->validate([
            'weather_api_key' => 'required|string|max:200',
            'weather_city'    => 'nullable|string|max:100',
            'weather_state'   => 'nullable|string|max:100',
            'weather_country' => 'nullable|string|max:50',
            'weather_lat'     => 'nullable|numeric|between:-90,90',
            'weather_lon'     => 'nullable|numeric|between:-180,180',
            'weather_cache_minutes' => 'nullable|integer|min:5|max:1440',
        ]);

        if (empty($validated['weather_cache_minutes'])) {
            $validated['weather_cache_minutes'] = '30';
        }

        SiteSetting::setMany($validated);

        $this->weather->forceRefresh();

        return redirect()->route('panel.weather')->with('success', 'Configuración del clima actualizada.');
    }

    public function refresh()
    {
        $data = $this->weather->forceRefresh();

        if ($data) {
            return response()->json(['success' => true, 'data' => $data]);
        }

        return response()->json(['success' => false, 'message' => 'No se pudo obtener el clima. Verifica la configuración.'], 422);
    }

    public function getWeatherData()
    {
        $data = $this->weather->getWeather();

        if ($data) {
            return response()->json(['success' => true, 'data' => $data]);
        }

        return response()->json(['success' => false, 'message' => 'Clima no disponible.'], 404);
    }
}
