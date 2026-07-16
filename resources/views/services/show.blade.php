@extends('layouts.app')
@section('title', 'Detalle Servicio')
@section('page-title', 'Servicio: ' . $service->name)

@section('content')
<div class="row g-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><h6 class="mb-0">Información del Servicio</h6></div>
            <div class="card-body">
                <p><strong>ID:</strong> {{ $service->id }}</p>
                <p><strong>Nombre:</strong> {{ $service->name }}</p>
                <p><strong>Descripción:</strong> {{ $service->description ?? '—' }}</p>
                <p><strong>Precio:</strong> ${{ number_format($service->price, 2) }}</p>
                <p><strong>Estado:</strong> <span class="badge bg-{{ $service->status=='activo'?'success':'secondary' }}">{{ ucfirst($service->status) }}</span></p>
                <p><strong>Creado:</strong> {{ $service->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Actualizado:</strong> {{ $service->updated_at->format('d/m/Y H:i') }}</p>
                <div class="mt-3">
                    <a href="{{ route('services.edit', $service) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil me-1"></i>Editar</a>
                    <a href="{{ route('services.index') }}" class="btn btn-sm btn-secondary"><i class="bi bi-arrow-left me-1"></i>Volver</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
