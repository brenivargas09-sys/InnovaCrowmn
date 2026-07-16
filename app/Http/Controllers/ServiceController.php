<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Http\Requests\ServiceRequest;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $services = Service::when($search, function ($q, $search) {
            $q->where('name', 'like', "%{$search}%");
        })
        ->latest()
        ->paginate(15)
        ->withQueryString();
        return view('services.index', compact('services', 'search'));
    }

    public function show(Service $service)
    {
        return view('services.show', compact('service'));
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(ServiceRequest $request)
    {
        $validated = $request->validated();

        Service::create($validated);
        return redirect()->route('services.index')->with('success', 'Servicio creado exitosamente.');
    }

    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    public function update(ServiceRequest $request, Service $service)
    {
        $validated = $request->validated();

        $service->update($validated);
        return redirect()->route('services.index')->with('success', 'Servicio actualizado.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Servicio eliminado.');
    }
}
