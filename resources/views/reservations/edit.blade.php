@extends('layouts.app')
@section('title', 'Editar Reservación')
@section('page-title', 'Editar Reservación #' . $reservation->id)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                @endif
                <form method="POST" action="{{ route('reservations.update', $reservation) }}">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Cliente</label>
                            <select name="client_id" class="form-select" required>
                                @foreach($clients as $c)<option value="{{ $c->id }}" {{ old('client_id', $reservation->client_id)==$c->id?'selected':'' }}>{{ $c->full_name }}</option>@endforeach
                            </select>
                        </div>
                        <div class="col-md-6"><label class="form-label">Habitación</label>
                            <select name="room_id" class="form-select" required>
                                @foreach($availableRooms as $r)<option value="{{ $r->id }}" {{ old('room_id', $reservation->room_id)==$r->id?'selected':'' }}>{{ $r->room_number }} - {{ $r->roomType->name }} (${{ number_format($r->roomType->price_per_night, 2) }})</option>@endforeach
                            </select>
                        </div>
                        <div class="col-md-3"><label class="form-label">Check-in</label><input type="date" name="check_in_date" class="form-control" value="{{ old('check_in_date', $reservation->check_in_date->format('Y-m-d')) }}" required></div>
                        <div class="col-md-3"><label class="form-label">Check-out</label><input type="date" name="check_out_date" class="form-control" value="{{ old('check_out_date', $reservation->check_out_date->format('Y-m-d')) }}" required></div>
                        <div class="col-md-3"><label class="form-label">Estado</label>
                            <select name="status" class="form-select">
                                @foreach(['pendiente','confirmada','cancelada','completada'] as $s)<option value="{{ $s }}" {{ old('status', $reservation->status)===$s?'selected':'' }}>{{ ucfirst($s) }}</option>@endforeach
                            </select>
                        </div>
                        <div class="col-md-3"><label class="form-label">Notas</label><input type="text" name="notes" class="form-control" value="{{ old('notes', $reservation->notes) }}"></div>
                    </div>
                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Actualizar</button>
                        <a href="{{ route('reservations.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
