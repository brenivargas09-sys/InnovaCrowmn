<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomType;
use App\Http\Requests\RoomTypeRequest;

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

    public function store(RoomTypeRequest $request)
    {
        $validated = $request->validated();

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

    public function update(RoomTypeRequest $request, RoomType $roomType)
    {
        $validated = $request->validated();

        $roomType->update($validated);
        return redirect()->route('room-types.index')->with('success', 'Tipo de habitación actualizado.');
    }

    public function destroy(RoomType $roomType)
    {
        $roomType->delete();
        return redirect()->route('room-types.index')->with('success', 'Tipo de habitación eliminado.');
    }
}
