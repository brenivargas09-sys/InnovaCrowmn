@extends('layouts.app')
@section('title', 'Dashboard - Recepcionista')
@section('page-title', 'Dashboard')

@section('content')

{{-- ── Welcome Banner ── --}}
<div class="card mb-5" style="background:linear-gradient(135deg,var(--primary) 0%,#162038 50%,#1c2a4a 100%);border:none;border-radius:16px;overflow:hidden;position:relative;">
    <div style="position:absolute;top:0;right:0;width:300px;height:100%;background:linear-gradient(135deg,rgba(201,169,110,.1),rgba(201,169,110,.01));border-radius:50% 0 0 50%;transform:translateX(30%);"></div>
    <div class="card-body py-4 px-4 px-md-5 position-relative" style="z-index:1;">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h4 style="color:#fff;font-weight:700;margin-bottom:.35rem;">
                    Bienvenido, {{ auth()->user()->first_name ?? auth()->user()->full_name }}
                </h4>
                <p style="color:rgba(255,255,255,.55);font-size:.85rem;margin-bottom:0;">
                    Panel de recepción. Gestiona check-ins, check-outs y reservaciones de los huéspedes.
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
    <h5><i class="bi bi-clipboard-data"></i> Resumen del Día</h5>
</div>
<div class="row g-4 mb-5">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-blue">
            <div class="stat-card-icon"><i class="bi bi-door-open"></i></div>
            <div class="stat-card-body">
                <div class="stat-card-label">Habitaciones</div>
                <div class="stat-card-value">{{ $stats['habitaciones_total'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-green">
            <div class="stat-card-icon"><i class="bi bi-check-circle"></i></div>
            <div class="stat-card-body">
                <div class="stat-card-label">Disponibles</div>
                <div class="stat-card-value">{{ $stats['habitaciones_disponibles'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-green">
            <div class="stat-card-icon"><i class="bi bi-box-arrow-in-right"></i></div>
            <div class="stat-card-body">
                <div class="stat-card-label">Check-ins Hoy</div>
                <div class="stat-card-value">{{ $stats['reservaciones_hoy'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-red">
            <div class="stat-card-icon"><i class="bi bi-hourglass-split"></i></div>
            <div class="stat-card-body">
                <div class="stat-card-label">Pendientes</div>
                <div class="stat-card-value">{{ $stats['reservaciones_pendientes'] }}</div>
            </div>
        </div>
    </div>
</div>

{{-- ── Quick Actions ── --}}
<div class="section-header">
    <h5><i class="bi bi-lightning"></i> Accesos Rápidos</h5>
</div>
<div class="row g-4">
    <div class="col-md-4">
        <a href="{{ route('checkins.index') }}" class="card module-card h-100 text-decoration-none">
            <div class="card-body d-flex align-items-center gap-3 py-3">
                <div class="module-icon" style="background:var(--success-bg);color:var(--success);">
                    <i class="bi bi-box-arrow-in-right"></i>
                </div>
                <div>
                    <div class="module-card-title mb-0">Check-In / Check-Out</div>
                    <div class="module-card-desc">Registrar ingresos y egresos</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('reservations.index') }}" class="card module-card h-100 text-decoration-none">
            <div class="card-body d-flex align-items-center gap-3 py-3">
                <div class="module-icon" style="background:var(--warning-bg);color:var(--warning);">
                    <i class="bi bi-calendar2-check"></i>
                </div>
                <div>
                    <div class="module-card-title mb-0">Reservaciones</div>
                    <div class="module-card-desc">Ver y gestionar reservas</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('clients.index') }}" class="card module-card h-100 text-decoration-none">
            <div class="card-body d-flex align-items-center gap-3 py-3">
                <div class="module-icon" style="background:var(--purple-bg);color:var(--purple);">
                    <i class="bi bi-people"></i>
                </div>
                <div>
                    <div class="module-card-title mb-0">Clientes</div>
                    <div class="module-card-desc">Registro de huéspedes</div>
                </div>
            </div>
        </a>
    </div>
</div>

@endsection
