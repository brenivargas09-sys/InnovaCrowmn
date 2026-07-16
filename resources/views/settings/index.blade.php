@extends('layouts.app')
@section('title', 'Configuración del Sitio')
@section('page-title', 'Configuración de la Página Principal')

@section('content')
<p class="text-muted mb-4">Edita el contenido que se muestra en la página pública del hotel. Los cambios se reflejan inmediatamente.</p>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-4">
                <i class="bi bi-card-image display-4 text-primary"></i>
                <h6 class="mt-3 fw-bold">Sección Hero</h6>
                <p class="text-muted small">Título, descripción e imagen principal</p>
                <a href="{{ route('settings.edit', 'hero') }}" class="btn btn-sm btn-outline-primary">Editar</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-4">
                <i class="bi bi-info-circle display-4 text-success"></i>
                <h6 class="mt-3 fw-bold">Nosotros</h6>
                <p class="text-muted small">Texto descriptivo del hotel</p>
                <a href="{{ route('settings.edit', 'about') }}" class="btn btn-sm btn-outline-success">Editar</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-4">
                <i class="bi bi-images display-4 text-warning"></i>
                <h6 class="mt-3 fw-bold">Galería</h6>
                <p class="text-muted small">Imágenes de la sección nosotros</p>
                <a href="{{ route('settings.edit', 'gallery') }}" class="btn btn-sm btn-outline-warning">Editar</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-4">
                <i class="bi bi-telephone display-4 text-info"></i>
                <h6 class="mt-3 fw-bold">Contacto</h6>
                <p class="text-muted small">Dirección, teléfono y email</p>
                <a href="{{ route('settings.edit', 'contact') }}" class="btn btn-sm btn-outline-info">Editar</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-4">
                <i class="bi bi-text-paragraph display-4 text-secondary"></i>
                <h6 class="mt-3 fw-bold">Footer</h6>
                <p class="text-muted small">Texto del pie de página</p>
                <a href="{{ route('settings.edit', 'footer') }}" class="btn btn-sm btn-outline-secondary">Editar</a>
            </div>
        </div>
    </div>
</div>
@endsection
