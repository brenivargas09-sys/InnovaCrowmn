<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%")
                  ->orWhere('id_number', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%");
            });
        }

        $clients = $query->latest()->paginate(15);
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:200',
            'city' => 'nullable|string|max:50',
            'id_type' => 'required|in:INE,Pasaporte,Licencia,Otro',
            'id_number' => 'required|string|max:30',
            'nationality' => 'nullable|string|max:50',
            'email' => 'required|email|unique:users',
            'username' => 'required|string|max:50|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'cliente',
            'status' => 'activo',
        ]);

        $user->client()->create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'city' => $validated['city'] ?? null,
            'id_type' => $validated['id_type'],
            'id_number' => $validated['id_number'],
            'nationality' => $validated['nationality'] ?? 'Mexicana',
        ]);

        return redirect()->route('clients.index')->with('success', 'Cliente registrado exitosamente.');
    }

    public function show(Client $client)
    {
        $client->load(['user', 'reservations.room.roomType']);
        return view('clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:200',
            'city' => 'nullable|string|max:50',
            'id_type' => 'required|in:INE,Pasaporte,Licencia,Otro',
            'id_number' => 'required|string|max:30',
            'nationality' => 'nullable|string|max:50',
        ]);

        $client->update($validated);
        return redirect()->route('clients.index')->with('success', 'Cliente actualizado.');
    }

    public function destroy(Client $client)
    {
        $client->user->delete();
        return redirect()->route('clients.index')->with('success', 'Cliente eliminado.');
    }
}
