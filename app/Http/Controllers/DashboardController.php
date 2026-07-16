<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Room;
use App\Models\Reservation;
use App\Models\Client;
use App\Models\Payment;
use App\Services\WeatherService;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $stats = $this->getStats($user);
        $reservaciones_recientes = $this->getRecentReservations($user);
        $weather = $user->role === 'admin' ? app(WeatherService::class)->getWeather() : null;

        $view = match ($user->role) {
            'admin' => 'dashboard-admin',
            'recepcionista' => 'dashboard-recepcionista',
            'cliente' => 'dashboard-cliente',
            default => 'dashboard-admin',
        };

        return view($view, compact('stats', 'reservaciones_recientes', 'weather'));
    }

    private function getStats($user): array
    {
        if ($user->role === 'cliente') {
            return $this->getClientStats($user);
        }

        return $this->getStaffStats();
    }

    private function getStaffStats(): array
    {
        return [
            'habitaciones_total' => Room::count(),
            'habitaciones_disponibles' => Room::where('status', 'disponible')->count(),
            'habitaciones_ocupadas' => Room::where('status', 'ocupada')->count(),
            'habitaciones_reservadas' => Room::where('status', 'reservada')->count(),
            'reservaciones_hoy' => Reservation::where('check_in_date', today())->count(),
            'checkouts_hoy' => Reservation::where('check_out_date', today())->count(),
            'reservaciones_pendientes' => Reservation::where('status', 'pendiente')->count(),
            'total_clientes' => Client::count(),
            'ingresos_mes' => Payment::whereMonth('payment_date', now()->month)
                ->whereYear('payment_date', now()->year)
                ->sum('amount'),
        ];
    }

    private function getClientStats($user): array
    {
        $clientId = $user->client->id ?? 0;

        return [
            'mis_reservaciones' => Reservation::where('client_id', $clientId)->count(),
            'confirmadas' => Reservation::where('client_id', $clientId)->where('status', 'confirmada')->count(),
            'pendientes' => Reservation::where('client_id', $clientId)->where('status', 'pendiente')->count(),
            'completadas' => Reservation::where('client_id', $clientId)->where('status', 'completada')->count(),
        ];
    }

    private function getRecentReservations($user)
    {
        if ($user->role === 'cliente') {
            $clientId = $user->client->id ?? 0;
            return Reservation::with(['room.roomType'])
                ->where('client_id', $clientId)
                ->latest()
                ->limit(10)
                ->get();
        }

        return Reservation::with(['client', 'room.roomType'])
            ->latest()
            ->limit(5)
            ->get();
    }
}
