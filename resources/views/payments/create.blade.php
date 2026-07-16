@extends('layouts.app')
@section('title', 'Registrar Pago')
@section('page-title', 'Nuevo Pago')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                @endif
                <form method="POST" action="{{ route('payments.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Reservación</label>
                            <select name="reservation_id" class="form-select" required>
                                <option value="">Seleccionar...</option>
                                @foreach($reservations as $r)
                                <option value="{{ $r->id }}" {{ old('reservation_id')==$r->id?'selected':'' }}>
                                    #{{ $r->id }} - {{ $r->client->full_name ?? 'N/A' }} (Hab. {{ $r->room->room_number ?? '' }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4"><label class="form-label">Monto ($)</label><input type="number" name="amount" class="form-control" step="0.01" min="0.01" value="{{ old('amount') }}" required></div>
                        <div class="col-md-4"><label class="form-label">Método de Pago</label>
                            <select name="payment_method" class="form-select" required>
                                <option value="efectivo">Efectivo</option>
                                <option value="tarjeta_credito">Tarjeta Crédito</option>
                                <option value="tarjeta_debito">Tarjeta Débito</option>
                                <option value="transferencia">Transferencia</option>
                            </select>
                        </div>
                        <div class="col-md-4"><label class="form-label">Fecha de Pago</label><input type="date" name="payment_date" class="form-control" value="{{ old('payment_date', date('Y-m-d')) }}" required></div>
                        <div class="col-md-6"><label class="form-label">Referencia</label><input type="text" name="reference_number" class="form-control" value="{{ old('reference_number') }}"></div>
                        <div class="col-md-6"><label class="form-label">Notas</label><input type="text" name="notes" class="form-control" value="{{ old('notes') }}"></div>
                    </div>
                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Registrar Pago</button>
                        <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
