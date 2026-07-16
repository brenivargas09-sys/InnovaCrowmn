@extends('layouts.app')
@section('title', 'Dashboard - Cliente')
@section('page-title', 'Mi Panel')

@section('content')

{{-- ── Welcome Banner ── --}}
<div class="card mb-5" style="background:linear-gradient(135deg,var(--primary) 0%,#162038 50%,#1c2a4a 100%);border:none;border-radius:16px;overflow:hidden;position:relative;">
    <div style="position:absolute;top:0;right:0;width:300px;height:100%;background:linear-gradient(135deg,rgba(201,169,110,.1),rgba(201,169,110,.01));border-radius:50% 0 0 50%;transform:translateX(30%);"></div>
    <div class="card-body py-4 px-4 px-md-5 position-relative" style="z-index:1;">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h4 style="color:#fff;font-weight:700;margin-bottom:.35rem;">
                    Hola, {{ auth()->user()->first_name ?? auth()->user()->full_name }}
                </h4>
                <p style="color:rgba(255,255,255,.55);font-size:.85rem;margin-bottom:0;">
                    Revisa el estado de tus reservaciones y gestiona tus futuras estancias en InnovaCrown.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <span style="color:var(--accent);font-weight:600;font-size:.95rem;">
                    <i class="bi bi-calendar3 me-1"></i>{{ now()->translatedFormat('l, d \d\e F \d\e Y') }}
                </span>
            </div>
        </div>
    </div>
</div>

{{-- ── Stats ── --}}
<div class="section-header">
    <h5><i class="bi bi-clipboard-data"></i> Mis Reservaciones</h5>
</div>
<div class="row g-4 mb-5">
    <div class="col-xl-4 col-md-6">
        <div class="stat-card stat-blue">
            <div class="stat-card-icon"><i class="bi bi-calendar2-check"></i></div>
            <div class="stat-card-body">
                <div class="stat-card-label">Total Reservaciones</div>
                <div class="stat-card-value">{{ $stats['mis_reservaciones'] ?? 0 }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="stat-card stat-green">
            <div class="stat-card-icon"><i class="bi bi-check-circle"></i></div>
            <div class="stat-card-body">
                <div class="stat-card-label">Confirmadas</div>
                <div class="stat-card-value">{{ $stats['confirmadas'] ?? 0 }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="stat-card stat-amber">
            <div class="stat-card-icon"><i class="bi bi-hourglass-split"></i></div>
            <div class="stat-card-body">
                <div class="stat-card-label">Pendientes</div>
                <div class="stat-card-value">{{ $stats['pendientes'] ?? 0 }}</div>
            </div>
        </div>
    </div>
</div>

{{-- ── Quick Actions ── --}}
<div class="section-header">
    <h5><i class="bi bi-lightning"></i> Accesos Rápidos</h5>
</div>
<div class="row g-4">
    <div class="col-md-6">
        <a href="{{ route('my.reservations') }}" class="card module-card h-100 text-decoration-none">
            <div class="card-body d-flex align-items-center gap-3 py-3">
                <div class="module-icon" style="background:var(--info-bg);color:var(--info);">
                    <i class="bi bi-calendar2-check"></i>
                </div>
                <div>
                    <div class="module-card-title mb-0">Mis Reservaciones</div>
                    <div class="module-card-desc">Ver historial y estado actual</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6">
        <a href="{{ route('welcome') }}" class="card module-card h-100 text-decoration-none" target="_blank">
            <div class="card-body d-flex align-items-center gap-3 py-3">
                <div class="module-icon" style="background:var(--accent-light);color:var(--accent-hover);">
                    <i class="bi bi-globe"></i>
                </div>
                <div>
                    <div class="module-card-title mb-0">Explorar Hotel</div>
                    <div class="module-card-desc">Ver habitaciones y servicios</div>
                </div>
            </div>
        </a>
    </div>
</div>

@endsection
