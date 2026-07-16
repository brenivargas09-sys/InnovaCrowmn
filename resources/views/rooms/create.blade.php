@extends('layouts.app')
@section('title', 'Nueva Habitación')
@section('page-title', 'Crear Habitación')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                @endif
                <form method="POST" action="{{ route('rooms.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label">Nº Habitación</label><input type="text" name="room_number" class="form-control" value="{{ old('room_number') }}" required></div>
                        <div class="col-md-4"><label class="form-label">Tipo</label>
                            <select name="room_type_id" class="form-select" required>
                                @foreach($roomTypes as $t)<option value="{{ $t->id }}">{{ $t->name }} - ${{ number_format($t->price_per_night, 2) }}/noche</option>@endforeach
                            </select>
                        </div>
                        <div class="col-md-4"><label class="form-label">Piso</label><input type="number" name="floor" class="form-control" value="{{ old('floor', 1) }}" min="1" required></div>
                        <div class="col-md-6"><label class="form-label">Estado</label>
                            <select name="status" class="form-select"><option value="disponible">Disponible</option><option value="reservada">Reservada</option><option value="ocupada">Ocupada</option><option value="mantenimiento">Mantenimiento</option></select>
                        </div>
                        <div class="col-md-12"><label class="form-label">Descripción</label><textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea></div>
                    </div>
                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Guardar</button>
                        <a href="{{ route('rooms.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
