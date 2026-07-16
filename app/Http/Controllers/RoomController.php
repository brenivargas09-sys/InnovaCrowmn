<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomType;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::with('roomType');

        if ($request->filled('search')) {
            $query->where('room_number', 'like', "%{$request->search}%");
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('floor')) {
            $query->where('floor', $request->floor);
        }
        if ($request->filled('room_type_id')) {
            $query->where('room_type_id', $request->room_type_id);
        }

        $rooms = $query->orderBy('room_number')->paginate(15);
        $roomTypes = RoomType::all();
        $floors = Room::distinct()->pluck('floor')->sort()->values();

        return view('rooms.index', compact('rooms', 'roomTypes', 'floors'));
    }

    public function create()
    {
        $roomTypes = RoomType::all();
        return view('rooms.create', compact('roomTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|max:10|unique:rooms',
            'room_type_id' => 'required|exists:room_types,id',
            'floor' => 'required|integer|min:1',
            'status' => 'required|in:disponible,reservada,ocupada,mantenimiento',
            'description' => 'nullable|string',
        ]);

        Room::create($validated);
        return redirect()->route('rooms.index')->with('success', 'Habitación creada exitosamente.');
    }

    public function show(Room $room)
    {
        $room->load('roomType');
        $reservaciones = $room->reservations()->with('client')->latest()->limit(10)->get();
        return view('rooms.show', compact('room', 'reservaciones'));
    }

    public function edit(Room $room)
    {
        $roomTypes = RoomType::all();
        return view('rooms.edit', compact('room', 'roomTypes'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|max:10|unique:rooms,room_number,' . $room->id,
            'room_type_id' => 'required|exists:room_types,id',
            'floor' => 'required|integer|min:1',
            'status' => 'required|in:disponible,reservada,ocupada,mantenimiento',
            'description' => 'nullable|string',
        ]);

        $room->update($validated);
        return redirect()->route('rooms.index')->with('success', 'Habitación actualizada.');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Habitación eliminada.');
    }
}
