<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistorialEstado;

class HistorialEstadoController extends Controller
{
    public function index(Request $request)
    {
        $query = HistorialEstado::with('cambiadoPor');

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        $historial = $query->latest()->paginate(20);

        return view('historial.index', compact('historial'));
    }
}
