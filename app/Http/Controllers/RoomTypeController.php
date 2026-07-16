<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomType;

class RoomTypeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $roomTypes = RoomType::withCount('rooms')
            ->when($search, function ($q, $search) {
                $q->where('name', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();
        return view('room-types.index', compact('roomTypes', 'search'));
    }

    public function create()
    {
        return view('room-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'nullable|string',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'image' => 'nullable|string|max:100',
        ]);

        RoomType::create($validated);
        return redirect()->route('room-types.index')->with('success', 'Tipo de habitación creado.');
    }

    public function show(RoomType $roomType)
    {
        $roomType->loadCount('rooms');
        return view('room-types.show', compact('roomType'));
    }

    public function edit(RoomType $roomType)
    {
        return view('room-types.edit', compact('roomType'));
    }

    public function update(Request $request, RoomType $roomType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'nullable|string',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'image' => 'nullable|string|max:100',
        ]);

        $roomType->update($validated);
        return redirect()->route('room-types.index')->with('success', 'Tipo de habitación actualizado.');
    }

    public function destroy(RoomType $roomType)
    {
        $roomType->delete();
        return redirect()->route('room-types.index')->with('success', 'Tipo de habitación eliminado.');
    }
}
