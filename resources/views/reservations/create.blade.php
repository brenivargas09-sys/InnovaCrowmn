@extends('layouts.app')
@section('title', 'Nueva Reservación')
@section('page-title', 'Crear Reservación')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                @endif
                <form method="POST" action="{{ route('reservations.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Cliente</label>
                            <select name="client_id" class="form-select" required>
                                <option value="">Seleccionar cliente...</option>
                                @foreach($clients as $c)<option value="{{ $c->id }}" {{ old('client_id')==$c->id?'selected':'' }}>{{ $c->full_name }} - {{ $c->id_number }}</option>@endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Habitación Disponible</label>
                            <select name="room_id" class="form-select" required>
                                <option value="">Seleccionar habitación...</option>
                                @foreach($availableRooms as $r)<option value="{{ $r->id }}" {{ old('room_id')==$r->id?'selected':'' }}>{{ $r->room_number }} - {{ $r->roomType->name }} (${{ number_format($r->roomType->price_per_night, 2) }}/noche)</option>@endforeach
                            </select>
                        </div>
                        <div class="col-md-4"><label class="form-label">Fecha Check-in</label><input type="date" name="check_in_date" class="form-control" value="{{ old('check_in_date') }}" required></div>
                        <div class="col-md-4"><label class="form-label">Fecha Check-out</label><input type="date" name="check_out_date" class="form-control" value="{{ old('check_out_date') }}" required></div>
                        <div class="col-md-4"><label class="form-label">Notas</label><input type="text" name="notes" class="form-control" value="{{ old('notes') }}"></div>
                    </div>
                    <div class="mt-3 p-3 bg-light rounded">
                        <small class="text-muted">El total se calculará automáticamente según el tipo de habitación y número de noches.</small>
                    </div>
                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Crear Reservación</button>
                        <a href="{{ route('reservations.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
