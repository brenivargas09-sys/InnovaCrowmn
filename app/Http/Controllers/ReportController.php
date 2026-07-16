<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Payment;
use App\Models\Room;
use App\Models\Client;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function reservaciones(Request $request)
    {
        $from = $request->from ?? now()->startOfMonth()->toDateString();
        $to = $request->to ?? now()->endOfMonth()->toDateString();

        $reservations = Reservation::with(['client', 'room.roomType'])
            ->whereBetween('check_in_date', [$from, $to])
            ->latest()
            ->get();

        $stats = [
            'total' => $reservations->count(),
            'completadas' => $reservations->where('status', 'completada')->count(),
            'pendientes' => $reservations->where('status', 'pendiente')->count(),
            'canceladas' => $reservations->where('status', 'cancelada')->count(),
            'ingresos' => $reservations->where('status', 'completada')->sum('total_amount'),
        ];

        $ingresosSemanal = collect();
        $startDate = Carbon::parse($from);
        $endDate = Carbon::parse($to);
        $week = 1;
        while ($startDate->lte($endDate)) {
            $weekEnd = $startDate->copy()->addDays(6)->lte($endDate) ? $startDate->copy()->addDays(6) : $endDate->copy();
            $weekTotal = Payment::whereBetween('payment_date', [$startDate->toDateString(), $weekEnd->toDateString()])->sum('amount');
            $ingresosSemanal->push([
                'semana' => "Sem {$week}",
                'total' => $weekTotal,
            ]);
            $startDate->addDays(7);
            $week++;
        }

        return view('reports.reservaciones', compact('reservations', 'stats', 'from', 'to', 'ingresosSemanal'));
    }

    public function habitaciones()
    {
        $rooms = Room::with('roomType')->get();

        $stats = [
            'total' => $rooms->count(),
            'disponibles' => $rooms->where('status', 'disponible')->count(),
            'ocupadas' => $rooms->where('status', 'ocupada')->count(),
            'reservadas' => $rooms->where('status', 'reservada')->count(),
            'mantenimiento' => $rooms->where('status', 'mantenimiento')->count(),
            'ocupacion_pct' => $rooms->count() > 0 ? round($rooms->where('status', 'ocupada')->count() / $rooms->count() * 100, 1) : 0,
        ];

        $tiposData = $rooms->groupBy(fn($r) => $r->roomType->name ?? 'Sin tipo')
            ->map(fn($group) => ['tipo' => $group->first()->roomType->name ?? 'Sin tipo', 'cantidad' => $group->count()])
            ->values();

        return view('reports.habitaciones', compact('rooms', 'stats', 'tiposData'));
    }

    public function ingresos(Request $request)
    {
        $from = $request->from ?? now()->startOfMonth()->toDateString();
        $to = $request->to ?? now()->endOfMonth()->toDateString();

        $payments = Payment::with(['reservation.client', 'reservation.room'])
            ->whereBetween('payment_date', [$from, $to])
            ->latest()
            ->get();

        $stats = [
            'total' => $payments->sum('amount'),
            'count' => $payments->count(),
            'efectivo' => $payments->where('payment_method', 'efectivo')->sum('amount'),
            'tarjeta_credito' => $payments->where('payment_method', 'tarjeta_credito')->sum('amount'),
            'tarjeta_debito' => $payments->where('payment_method', 'tarjeta_debito')->sum('amount'),
            'transferencia' => $payments->where('payment_method', 'transferencia')->sum('amount'),
        ];

        $ingresosDiarios = collect();
        $start = Carbon::parse($from);
        $end = Carbon::parse($to);
        while ($start->lte($end)) {
            $dayTotal = Payment::whereDate('payment_date', $start->toDateString())->sum('amount');
            $ingresosDiarios->push([
                'dia' => $start->format('d/m'),
                'total' => $dayTotal,
            ]);
            $start->addDay();
        }

        return view('reports.ingresos', compact('payments', 'stats', 'from', 'to', 'ingresosDiarios'));
    }
}
