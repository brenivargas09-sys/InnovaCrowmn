<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\ReservationService;

class ReservationServiceController extends Controller
{
    public function store(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'quantity' => 'required|integer|min:1|max:99',
            'notes' => 'nullable|string|max:200',
        ]);

        $service = Service::findOrFail($validated['service_id']);
        $subtotal = $service->price * $validated['quantity'];

        $reservation->reservationServices()->updateOrCreate(
            ['service_id' => $validated['service_id']],
            [
                'quantity' => $validated['quantity'],
                'subtotal' => $subtotal,
                'notes' => $validated['notes'] ?? null,
            ]
        );

        return redirect()->route('reservations.show', $reservation)->with('success', 'Servicio agregado a la reservación.');
    }

    public function destroy(Reservation $reservation, ReservationService $reservationService)
    {
        $reservationService->delete();
        return redirect()->route('reservations.show', $reservation)->with('success', 'Servicio removido de la reservación.');
    }
}
