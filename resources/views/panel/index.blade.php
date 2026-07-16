@extends('layouts.app')
@section('title', 'Configuración del Sitio')
@section('page-title', 'Configuración del Sitio')

@section('content')

<div class="section-header">
    <h5><i class="bi bi-gear"></i> Gestión del Sitio Web</h5>
</div>

<div class="row g-3">
    <div class="col-lg-4 col-md-6">
        <a href="{{ route('panel.hero') }}" class="card module-card h-100 text-decoration-none">
            <div class="card-body d-flex align-items-center gap-3 py-3">
                <div class="module-icon" style="background:var(--info-bg);color:var(--info);width:44px;height:44px;border-radius:10px;font-size:1.15rem;">
                    <i class="bi bi-image"></i>
                </div>
                <div>
                    <div class="module-card-title mb-0">Banner Principal</div>
                    <div class="module-card-desc">Imágenes, títulos y descripción del hero</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-4 col-md-6">
        <a href="{{ route('panel.info') }}" class="card module-card h-100 text-decoration-none">
            <div class="card-body d-flex align-items-center gap-3 py-3">
                <div class="module-icon" style="background:var(--purple-bg);color:var(--purple);width:44px;height:44px;border-radius:10px;font-size:1.15rem;">
                    <i class="bi bi-info-circle"></i>
                </div>
                <div>
                    <div class="module-card-title mb-0">Información del Hotel</div>
                    <div class="module-card-desc">Historia, misión, visión, contacto</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-4 col-md-6">
        <a href="{{ route('panel.rooms') }}" class="card module-card h-100 text-decoration-none">
            <div class="card-body d-flex align-items-center gap-3 py-3">
                <div class="module-icon" style="background:var(--success-bg);color:var(--success);width:44px;height:44px;border-radius:10px;font-size:1.15rem;">
                    <i class="bi bi-door-open"></i>
                </div>
                <div>
                    <div class="module-card-title mb-0">Tipos de Habitación</div>
                    <div class="module-card-desc">Catálogo de habitaciones y precios</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-4 col-md-6">
        <a href="{{ route('panel.services') }}" class="card module-card h-100 text-decoration-none">
            <div class="card-body d-flex align-items-center gap-3 py-3">
                <div class="module-icon" style="background:var(--warning-bg);color:var(--warning);width:44px;height:44px;border-radius:10px;font-size:1.15rem;">
                    <i class="bi bi-concierge-bell"></i>
                </div>
                <div>
                    <div class="module-card-title mb-0">Servicios</div>
                    <div class="module-card-desc">Agregar, editar o desactivar servicios</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-4 col-md-6">
        <a href="{{ route('panel.promotions') }}" class="card module-card h-100 text-decoration-none">
            <div class="card-body d-flex align-items-center gap-3 py-3">
                <div class="module-icon" style="background:var(--danger-bg);color:var(--danger);width:44px;height:44px;border-radius:10px;font-size:1.15rem;">
                    <i class="bi bi-megaphone"></i>
                </div>
                <div>
                    <div class="module-card-title mb-0">Promociones</div>
                    <div class="module-card-desc">Ofertas y promociones destacadas</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-4 col-md-6">
        <a href="{{ route('panel.gallery') }}" class="card module-card h-100 text-decoration-none">
            <div class="card-body d-flex align-items-center gap-3 py-3">
                <div class="module-icon" style="background:var(--accent-light);color:var(--accent-hover);width:44px;height:44px;border-radius:10px;font-size:1.15rem;">
                    <i class="bi bi-images"></i>
                </div>
                <div>
                    <div class="module-card-title mb-0">Galería de Imágenes</div>
                    <div class="module-card-desc">Fotos de las instalaciones</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-4 col-md-6">
        <a href="{{ route('panel.weather') }}" class="card module-card h-100 text-decoration-none">
            <div class="card-body d-flex align-items-center gap-3 py-3">
                <div class="module-icon" style="background:rgba(59,130,246,.1);color:#3b82f6;width:44px;height:44px;border-radius:10px;font-size:1.15rem;">
                    <i class="bi bi-cloud-sun"></i>
                </div>
                <div>
                    <div class="module-card-title mb-0">Clima en Vivo</div>
                    <div class="module-card-desc">API OpenWeather - Widget y configuración</div>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="card border-0 mt-4" style="background:linear-gradient(135deg,var(--primary) 0%,#162038 100%);">
    <div class="card-body py-3 px-4 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3">
            <i class="bi bi-eye fs-5" style="color:var(--accent);"></i>
            <span style="color:rgba(255,255,255,.7);font-size:.85rem;">Vista previa de los cambios en tiempo real</span>
        </div>
        <a href="{{ route('welcome') }}" target="_blank" class="btn btn-sm" style="background:var(--accent);color:#fff;">
            <i class="bi bi-box-arrow-up-right me-1"></i>Ver Sitio Web
        </a>
    </div>
</div>

@endsection
