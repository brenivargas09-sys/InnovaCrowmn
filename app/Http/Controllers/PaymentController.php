<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
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

    public function store(StorePaymentRequest $request)
    {
        $validated = $request->validated();

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

    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        $validated = $request->validated();

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
