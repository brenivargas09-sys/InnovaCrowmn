@extends('layouts.app')
@section('title', 'Editar Pago')
@section('page-title', 'Editar Pago')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                @endif
                <form method="POST" action="{{ route('payments.update', $payment) }}">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Reservación</label>
                            <select name="reservation_id" class="form-select" required>
                                <option value="">Seleccionar...</option>
                                @foreach($reservations as $r)
                                <option value="{{ $r->id }}" {{ old('reservation_id', $payment->reservation_id)==$r->id?'selected':'' }}>
                                    #{{ $r->id }} - {{ $r->client->full_name ?? 'N/A' }} (Hab. {{ $r->room->room_number ?? '' }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4"><label class="form-label">Monto ($)</label><input type="number" name="amount" class="form-control" step="0.01" min="0.01" value="{{ old('amount', $payment->amount) }}" required></div>
                        <div class="col-md-4"><label class="form-label">Método de Pago</label>
                            <select name="payment_method" class="form-select" required>
                                <option value="efectivo" {{ old('payment_method', $payment->payment_method)=='efectivo'?'selected':'' }}>Efectivo</option>
                                <option value="tarjeta_credito" {{ old('payment_method', $payment->payment_method)=='tarjeta_credito'?'selected':'' }}>Tarjeta Crédito</option>
                                <option value="tarjeta_debito" {{ old('payment_method', $payment->payment_method)=='tarjeta_debito'?'selected':'' }}>Tarjeta Débito</option>
                                <option value="transferencia" {{ old('payment_method', $payment->payment_method)=='transferencia'?'selected':'' }}>Transferencia</option>
                            </select>
                        </div>
                        <div class="col-md-4"><label class="form-label">Fecha de Pago</label><input type="date" name="payment_date" class="form-control" value="{{ old('payment_date', $payment->payment_date->format('Y-m-d')) }}" required></div>
                        <div class="col-md-6"><label class="form-label">Referencia</label><input type="text" name="reference_number" class="form-control" value="{{ old('reference_number', $payment->reference_number) }}"></div>
                        <div class="col-md-6"><label class="form-label">Notas</label><input type="text" name="notes" class="form-control" value="{{ old('notes', $payment->notes) }}"></div>
                    </div>
                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Actualizar Pago</button>
                        <a href="{{ route('payments.show', $payment) }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
