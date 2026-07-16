@extends('layouts.app')
@section('title', 'Detalle Tipo de Habitación')
@section('page-title', 'Tipo de Habitación: ' . $roomType->name)

@section('content')
<div class="row g-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between">
                <h6 class="mb-0">Información General</h6>
                <a href="{{ route('room-types.edit', $roomType) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
            </div>
            <div class="card-body">
                <p><strong>ID:</strong> {{ $roomType->id }}</p>
                <p><strong>Nombre:</strong> {{ $roomType->name }}</p>
                <p><strong>Descripción:</strong> {{ $roomType->description ?? '—' }}</p>
                <p><strong>Precio/Noche:</strong> ${{ number_format($roomType->price_per_night, 2) }}</p>
                <p><strong>Capacidad:</strong> {{ $roomType->capacity }} personas</p>
                <p><strong>Habitaciones:</strong> <span class="badge bg-secondary">{{ $roomType->rooms_count }}</span></p>
                <p><strong>Creado:</strong> {{ $roomType->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Actualizado:</strong> {{ $roomType->updated_at->format('d/m/Y H:i') }}</p>
                <a href="{{ route('room-types.index') }}" class="btn btn-sm btn-outline-secondary mt-2"><i class="bi bi-arrow-left me-1"></i>Volver</a>
            </div>
        </div>
    </div>
</div>
@endsection