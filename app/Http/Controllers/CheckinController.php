<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checkin;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\HistorialEstado;

class CheckinController extends Controller
{
    public function index()
    {
        $pendientes = Reservation::with(['client', 'room.roomType'])
            ->whereIn('status', ['confirmada', 'pendiente'])
            ->where('check_in_date', '<=', now())
            ->get();

        $checkoutsHoy = Checkin::with(['reservation.client', 'reservation.room'])
            ->whereNull('actual_check_out')
            ->whereDate('actual_check_in', today())
            ->get();

        $checkinsHoy = Checkin::with(['reservation.client', 'reservation.room'])
            ->whereDate('actual_check_in', today())
            ->latest()
            ->get();

        return view('checkins.index', compact('pendientes', 'checkoutsHoy', 'checkinsHoy'));
    }

    public function checkin(Reservation $reservation)
    {
        $oldStatus = $reservation->status;
        $reservation->update(['status' => 'confirmada']);
        $reservation->room->update(['status' => 'ocupada']);

        Checkin::create([
            'reservation_id' => $reservation->id,
            'actual_check_in' => now(),
            'created_by' => auth()->id(),
        ]);

        HistorialEstado::create([
            'tipo' => 'checkin',
            'registro_id' => $reservation->id,
            'estado_anterior' => $oldStatus,
            'estado_nuevo' => 'confirmada',
            'cambiado_por' => auth()->id(),
            'observaciones' => "Check-in realizado. Habitación {$reservation->room->room_number} ocupada.",
        ]);

        return redirect()->route('checkins.index')->with('success', "Check-in realizado para {$reservation->client->full_name} en habitación {$reservation->room->room_number}.");
    }

    public function checkout(Checkin $checkin)
    {
        $checkin->update(['actual_check_out' => now()]);

        $oldStatus = $checkin->reservation->status;
        $checkin->reservation->update(['status' => 'completada']);
        $checkin->reservation->room->update(['status' => 'disponible']);

        HistorialEstado::create([
            'tipo' => 'checkout',
            'registro_id' => $checkin->reservation_id,
            'estado_anterior' => $oldStatus,
            'estado_nuevo' => 'completada',
            'cambiado_por' => auth()->id(),
            'observaciones' => "Check-out realizado. Habitación {$checkin->reservation->room->room_number} liberada.",
        ]);

        return redirect()->route('checkins.index')->with('success', 'Check-out realizado exitosamente.');
    }
}
