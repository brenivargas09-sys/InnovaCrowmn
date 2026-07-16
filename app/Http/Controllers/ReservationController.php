<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Models\Reservation;
use App\Models\Client;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\HistorialEstado;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservation::with(['client', 'room.roomType', 'createdBy']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('client', function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%");
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if (auth()->user()->isCliente()) {
            $query->where('client_id', auth()->user()->client->id ?? 0);
        }

        $reservations = $query->latest()->paginate(15);
        return view('reservations.index', compact('reservations'));
    }

    public function create()
    {
        $clients = Client::all();
        $availableRooms = Room::where('status', 'disponible')->with('roomType')->get();
        $roomTypes = RoomType::all();
        return view('reservations.create', compact('clients', 'availableRooms', 'roomTypes'));
    }

    public function store(StoreReservationRequest $request)
    {
        $validated = $request->validated();

        $room = Room::with('roomType')->findOrFail($validated['room_id']);
        $nights = \Carbon\Carbon::parse($validated['check_in_date'])->diffInDays($validated['check_out_date']);
        $validated['total_amount'] = $room->roomType->price_per_night * $nights;
        $validated['created_by'] = auth()->id();
        $validated['status'] = 'pendiente';

        $reservation = Reservation::create($validated);
        $room->update(['status' => 'reservada']);

        HistorialEstado::create([
            'tipo' => 'reservacion',
            'registro_id' => $reservation->id,
            'estado_anterior' => null,
            'estado_nuevo' => 'pendiente',
            'cambiado_por' => auth()->id(),
            'observaciones' => "Reservación creada para {$reservation->client->full_name} en habitación {$room->room_number}.",
        ]);

        return redirect()->route('reservations.index')->with('success', 'Reservación creada. Total: $' . number_format($validated['total_amount'], 2));
    }

    public function show(Reservation $reservation)
    {
        $reservation->load(['client', 'room.roomType', 'createdBy', 'checkins.createdBy', 'payments.createdBy', 'reservationServices.service']);
        return view('reservations.show', compact('reservation'));
    }

    public function edit(Reservation $reservation)
    {
        $clients = Client::all();
        $availableRooms = Room::where('status', 'disponible')
            ->orWhere('id', $reservation->room_id)
            ->with('roomType')
            ->get();
        $roomTypes = RoomType::all();
        return view('reservations.edit', compact('reservation', 'clients', 'availableRooms', 'roomTypes'));
    }

    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        $validated = $request->validated();

        $oldStatus = $reservation->status;
        $oldRoomId = $reservation->room_id;
        $room = Room::with('roomType')->findOrFail($validated['room_id']);
        $nights = \Carbon\Carbon::parse($validated['check_in_date'])->diffInDays($validated['check_out_date']);
        $validated['total_amount'] = $room->roomType->price_per_night * $nights;

        $reservation->update($validated);

        if ($oldRoomId != $validated['room_id']) {
            Room::where('id', $oldRoomId)->whereIn('status', ['reservada', 'ocupada'])->update(['status' => 'disponible']);
        }

        if ($validated['status'] === 'cancelada') {
            Room::where('id', $validated['room_id'])->update(['status' => 'disponible']);
        } elseif ($validated['status'] === 'completada') {
            Room::where('id', $validated['room_id'])->update(['status' => 'disponible']);
        }

        if ($oldStatus !== $validated['status']) {
            HistorialEstado::create([
                'tipo' => 'reservacion',
                'registro_id' => $reservation->id,
                'estado_anterior' => $oldStatus,
                'estado_nuevo' => $validated['status'],
                'cambiado_por' => auth()->id(),
                'observaciones' => "Estado cambiado de '{$oldStatus}' a '{$validated['status']}'.",
            ]);
        }

        return redirect()->route('reservations.index')->with('success', 'Reservación actualizada.');
    }

    public function destroy(Reservation $reservation)
    {
        $oldStatus = $reservation->status;

        Room::where('id', $reservation->room_id)
            ->whereIn('status', ['reservada', 'ocupada'])
            ->update(['status' => 'disponible']);

        HistorialEstado::create([
            'tipo' => 'reservacion',
            'registro_id' => $reservation->id,
            'estado_anterior' => $oldStatus,
            'estado_nuevo' => 'eliminada',
            'cambiado_por' => auth()->id(),
            'observaciones' => 'Reservación eliminada del sistema.',
        ]);

        $reservation->delete();
        return redirect()->route('reservations.index')->with('success', 'Reservación eliminada.');
    }
}
