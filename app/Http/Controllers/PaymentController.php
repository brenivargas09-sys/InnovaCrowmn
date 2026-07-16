<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\HistorialEstado;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['reservation.client', 'reservation.room', 'createdBy']);

        if ($request->filled('search')) {
            $query->where('reference_number', 'like', "%{$request->search}%");
        }
        if ($request->filled('method')) {
            $query->where('payment_method', $request->method);
        }

        $payments = $query->latest()->paginate(15);
        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        $reservations = Reservation::with(['client', 'room'])
            ->whereIn('status', ['pendiente', 'confirmada'])
            ->get();
        return view('payments.create', compact('reservations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'amount' => 'required|numeric|min:0.01|max:999999.99',
            'payment_method' => 'required|in:efectivo,tarjeta_credito,tarjeta_debito,transferencia',
            'payment_date' => 'required|date|before_or_equal:today',
            'reference_number' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:500',
        ]);

        $validated['created_by'] = auth()->id();
        $payment = Payment::create($validated);

        HistorialEstado::create([
            'tipo' => 'pago',
            'registro_id' => $payment->id,
            'estado_anterior' => null,
            'estado_nuevo' => 'registrado',
            'cambiado_por' => auth()->id(),
            'observaciones' => "Pago de $" . number_format($payment->amount, 2) . " registrado via {$payment->payment_method}.",
        ]);

        return redirect()->route('payments.index')->with('success', 'Pago registrado exitosamente.');
    }

    public function show(Payment $payment)
    {
        $payment->load(['reservation.client', 'reservation.room.roomType', 'createdBy']);
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $reservations = Reservation::with(['client', 'room'])
            ->whereIn('status', ['pendiente', 'confirmada'])
            ->get();
        return view('payments.edit', compact('payment', 'reservations'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:efectivo,tarjeta_credito,tarjeta_debito,transferencia',
            'payment_date' => 'required|date|before_or_equal:today',
            'reference_number' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:500',
        ]);

        $payment->update($validated);
        return redirect()->route('payments.show', $payment)->with('success', 'Pago actualizado exitosamente.');
    }

    public function destroy(Payment $payment)
    {
        HistorialEstado::create([
            'tipo' => 'pago',
            'registro_id' => $payment->id,
            'estado_anterior' => 'registrado',
            'estado_nuevo' => 'eliminado',
            'cambiado_por' => auth()->id(),
            'observaciones' => "Pago de $" . number_format($payment->amount, 2) . " eliminado.",
        ]);

        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Pago eliminado.');
    }
}
