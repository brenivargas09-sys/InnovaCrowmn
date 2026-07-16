@extends('layouts.app')
@section('title', 'Pago #' . $payment->id)
@section('page-title', 'Detalle de Pago #' . $payment->id)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6"><strong>Reservación:</strong> #{{ $payment->reservation_id }}</div>
                    <div class="col-md-6"><strong>Cliente:</strong> {{ $payment->reservation->client->full_name ?? 'N/A' }}</div>
                    <div class="col-md-6"><strong>Habitación:</strong> {{ $payment->reservation->room->room_number ?? 'N/A' }}</div>
                    <div class="col-md-6"><strong>Monto:</strong> <span class="text-success fw-bold">${{ number_format($payment->amount, 2) }}</span></div>
                    <div class="col-md-6"><strong>Método:</strong> {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</div>
                    <div class="col-md-6"><strong>Fecha:</strong> {{ $payment->payment_date->format('d/m/Y') }}</div>
                    <div class="col-md-6"><strong>Referencia:</strong> {{ $payment->reference_number ?? '—' }}</div>
                    <div class="col-md-6"><strong>Registrado por:</strong> {{ $payment->createdBy->username ?? 'N/A' }}</div>
                    @if($payment->notes)<div class="col-12"><strong>Notas:</strong> {{ $payment->notes }}</div>@endif
                </div>
                <div class="mt-4 d-flex gap-2">
                    <a href="{{ route('payments.edit', $payment) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil me-1"></i>Editar</a>
                    <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">Volver</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
