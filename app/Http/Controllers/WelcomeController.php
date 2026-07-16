<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use App\Models\Service;
use App\Models\Client;
use App\Models\Room;
use App\Models\Promotion;
use App\Models\SiteSetting;
use App\Services\WeatherService;

class WelcomeController extends Controller
{
    public function __invoke()
    {
        $settings = SiteSetting::getAll();
        $roomTypes = RoomType::orderBy('price_per_night', 'asc')->get();
        $services = Service::where('status', 'activo')->orderBy('name')->get();
        $promotions = Promotion::active()->orderBy('sort_order')->limit(3)->get();
        $gallery = SiteSetting::where('type', 'gallery')->get();

        $stats = [
            'total_rooms' => Room::count(),
            'total_types' => $roomTypes->count(),
            'total_services' => $services->count(),
            'total_clients' => Client::count(),
        ];

        $weather = app(WeatherService::class)->getWeather();

        return view('welcome', compact('settings', 'roomTypes', 'services', 'promotions', 'gallery', 'stats', 'weather'));
    }
}
