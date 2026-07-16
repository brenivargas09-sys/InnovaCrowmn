@extends('layouts.app')
@section('title', 'Dashboard - Administrador')
@section('page-title', 'Dashboard')

@section('content')

{{-- ── Welcome Banner ── --}}
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="card" style="background:linear-gradient(135deg,var(--primary) 0%,#162038 50%,#1c2a4a 100%);border:none;border-radius:16px;overflow:hidden;position:relative;">
            <div style="position:absolute;top:0;right:0;width:260px;height:100%;background:linear-gradient(135deg,rgba(201,169,110,.1),rgba(201,169,110,.01));border-radius:50% 0 0 50%;transform:translateX(30%);"></div>
            <div class="card-body py-4 px-4 px-md-5 position-relative" style="z-index:1;">
                <h4 style="color:#fff;font-weight:700;margin-bottom:.35rem;">
                    Bienvenido, {{ auth()->user()->first_name ?? auth()->user()->full_name }}
                </h4>
                <p style="color:rgba(255,255,255,.55);font-size:.85rem;margin-bottom:0;">
                    Panel de administración del sistema hotelero. Gestiona habitaciones, reservaciones, clientes y más desde un solo lugar.
                </p>
                <div class="mt-3">
                    <span style="color:var(--accent);font-weight:600;font-size:.9rem;">
                        <i class="bi bi-calendar3 me-1"></i>{{ now()->translatedFormat('l, d \d\e F \d\e Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── Weather Card Full Width ── --}}
@if($weather)
<div class="row g-4 mb-5">
    <div class="col-12">
        <div class="card" style="background:linear-gradient(135deg,var(--primary) 0%,#162038 50%,#1c2a4a 100%);border:none;border-radius:16px;overflow:hidden;position:relative;" id="weatherCard">
            <div style="position:absolute;top:-60px;right:-60px;width:220px;height:220px;background:rgba(201,169,110,.06);border-radius:50%;"></div>
            <div style="position:absolute;bottom:-40px;left:-40px;width:160px;height:160px;background:rgba(201,169,110,.04);border-radius:50%;"></div>
            <div class="card-body py-4 px-4 px-md-5 position-relative" style="z-index:1;">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-cloud-sun-fill" style="color:var(--accent);font-size:1rem;"></i>
                        <span style="color:rgba(255,255,255,.7);font-size:.8rem;font-weight:600;text-transform:uppercase;letter-spacing:1.5px;">Clima en Vivo</span>
                    </div>
                    <a href="{{ route('panel.weather') }}" class="btn btn-sm" style="background:rgba(255,255,255,.08);color:rgba(255,255,255,.5);border:1px solid rgba(255,255,255,.1);font-size:.72rem;border-radius:8px;" title="Configurar clima">
                        <i class="bi bi-gear me-1"></i>Configurar
                    </a>
                </div>
                <div class="d-flex align-items-center gap-4 flex-wrap">
                    <div class="d-flex align-items-center gap-3">
                        <img src="{{ $weather['icon_url'] }}" alt="{{ $weather['description'] }}" style="width:64px;height:64px;filter:drop-shadow(0 3px 10px rgba(0,0,0,.3));">
                        <div>
                            <div style="color:#fff;font-size:2.5rem;font-weight:700;line-height:1;font-family:'Playfair Display',serif;">{{ $weather['temp'] }}°C</div>
                            <div style="color:rgba(255,255,255,.6);font-size:.85rem;margin-top:2px;">{{ $weather['description'] }}</div>
                        </div>
                    </div>
                    <div style="width:1px;height:40px;background:rgba(255,255,255,.1);margin:0 .5rem;" class="d-none d-md-block"></div>
                    <div class="d-flex gap-4 flex-wrap" style="font-size:.8rem;">
                        <div class="text-center">
                            <div style="color:var(--accent);font-size:1rem;"><i class="bi bi-thermometer-half"></i></div>
                            <div style="color:rgba(255,255,255,.8);font-weight:600;">{{ $weather['feels_like'] }}°C</div>
                            <div style="color:rgba(255,255,255,.3);font-size:.65rem;text-transform:uppercase;letter-spacing:.5px;">Sensación</div>
                        </div>
                        <div class="text-center">
                            <div style="color:var(--accent);font-size:1rem;"><i class="bi bi-droplet"></i></div>
                            <div style="color:rgba(255,255,255,.8);font-weight:600;">{{ $weather['humidity'] }}%</div>
                            <div style="color:rgba(255,255,255,.3);font-size:.65rem;text-transform:uppercase;letter-spacing:.5px;">Humedad</div>
                        </div>
                        <div class="text-center">
                            <div style="color:var(--accent);font-size:1rem;"><i class="bi bi-wind"></i></div>
                            <div style="color:rgba(255,255,255,.8);font-weight:600;">{{ $weather['wind_speed'] }} km/h</div>
                            <div style="color:rgba(255,255,255,.3);font-size:.65rem;text-transform:uppercase;letter-spacing:.5px;">Viento</div>
                        </div>
                        <div class="text-center">
                            <div style="color:var(--accent);font-size:1rem;"><i class="bi bi-speedometer"></i></div>
                            <div style="color:rgba(255,255,255,.8);font-weight:600;">{{ $weather['pressure'] }} hPa</div>
                            <div style="color:rgba(255,255,255,.3);font-size:.65rem;text-transform:uppercase;letter-spacing:.5px;">Presión</div>
                        </div>
                        <div class="text-center">
                            <div style="color:var(--accent);font-size:1rem;"><i class="bi bi-eye"></i></div>
                            <div style="color:rgba(255,255,255,.8);font-weight:600;">{{ $weather['visibility'] }} km</div>
                            <div style="color:rgba(255,255,255,.3);font-size:.65rem;text-transform:uppercase;letter-spacing:.5px;">Visibilidad</div>
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-4 flex-wrap mt-3" style="font-size:.78rem;color:rgba(255,255,255,.35);">
                    <span><i class="bi bi-geo-alt me-1" style="color:var(--accent);"></i>{{ $weather['city_name'] }}, {{ $weather['country'] }}</span>
                    @if(!empty($weather['sunrise']))
                    <span><i class="bi bi-sunrise me-1" style="color:var(--accent);"></i>Amanecer: {{ $weather['sunrise'] }}</span>
                    @endif
                    @if(!empty($weather['sunset']))
                    <span><i class="bi bi-sunset me-1" style="color:var(--accent);"></i>Atardecer: {{ $weather['sunset'] }}</span>
                    @endif
                    <span class="ms-auto"><i class="bi bi-arrow-clockwise me-1"></i>{{ $weather['updated_at'] }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="row g-4 mb-5">
    <div class="col-12">
        <div class="card" style="background:linear-gradient(135deg,var(--primary) 0%,#162038 50%,#1c2a4a 100%);border:none;border-radius:16px;overflow:hidden;">
            <div class="card-body py-4 px-4 text-center d-flex align-items-center justify-content-center gap-3">
                <a href="{{ route('panel.weather') }}" class="text-decoration-none d-flex align-items-center gap-3" style="color:rgba(255,255,255,.35);">
                    <i class="bi bi-cloud-slash fs-3" style="opacity:.4;"></i>
                    <div class="text-start">
                        <span style="font-size:.85rem;display:block;font-weight:500;">Configurar clima en vivo</span>
                        <span style="font-size:.7rem;display:block;margin-top:.15rem;color:var(--accent);">Integración con OpenWeather API</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endif

{{-- ── Stats Row 1: Habitaciones ── --}}
<div class="section-header">
    <h5><i class="bi bi-building"></i> Resumen de Habitaciones</h5>
</div>
<div class="row g-4 mb-5">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-blue">
            <div class="stat-card-icon"><i class="bi bi-door-open"></i></div>
            <div class="stat-card-body">
                <div class="stat-card-label">Total Habitaciones</div>
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
        <div class="stat-card stat-amber">
            <div class="stat-card-icon"><i class="bi bi-person-workspace"></i></div>
            <div class="stat-card-body">
                <div class="stat-card-label">Ocupadas</div>
                <div class="stat-card-value">{{ $stats['habitaciones_ocupadas'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-gold">
            <div class="stat-card-icon"><i class="bi bi-currency-dollar"></i></div>
            <div class="stat-card-body">
                <div class="stat-card-label">Ingresos del Mes</div>
                <div class="stat-card-value">${{ number_format($stats['ingresos_mes'], 2) }}</div>
            </div>
        </div>
    </div>
</div>

{{-- ── Stats Row 2: Operaciones ── --}}
<div class="section-header">
    <h5><i class="bi bi-clipboard-data"></i> Operaciones del Día</h5>
</div>
<div class="row g-4 mb-5">
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
        <div class="stat-card stat-amber">
            <div class="stat-card-icon"><i class="bi bi-box-arrow-right"></i></div>
            <div class="stat-card-body">
                <div class="stat-card-label">Check-outs Hoy</div>
                <div class="stat-card-value">{{ $stats['checkouts_hoy'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-purple">
            <div class="stat-card-icon"><i class="bi bi-people"></i></div>
            <div class="stat-card-body">
                <div class="stat-card-label">Total Clientes</div>
                <div class="stat-card-value">{{ $stats['total_clientes'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-red">
            <div class="stat-card-icon"><i class="bi bi-hourglass-split"></i></div>
            <div class="stat-card-body">
                <div class="stat-card-label">Reservaciones Pendientes</div>
                <div class="stat-card-value">{{ $stats['reservaciones_pendientes'] }}</div>
            </div>
        </div>
    </div>
</div>

{{-- ── Module Grid + Recent Reservations ── --}}
<div class="row g-4">
    {{-- Módulos del Sistema --}}
    <div class="col-lg-5">
        <div class="section-header">
            <h5><i class="bi bi-grid"></i> Módulos del Sistema</h5>
        </div>
        <div class="row g-3">
            <div class="col-6">
                <a href="{{ route('panel.users.index') }}" class="card module-card h-100 text-decoration-none">
                    <div class="card-body text-center py-3 px-2">
                        <div class="module-icon mx-auto mb-2" style="background:var(--info-bg);color:var(--info);">
                            <i class="bi bi-person-gear"></i>
                        </div>
                        <div class="module-card-title">Usuarios</div>
                        <div class="module-card-desc">Cuentas y permisos</div>
                    </div>
                </a>
            </div>
            <div class="col-6">
                <a href="{{ route('clients.index') }}" class="card module-card h-100 text-decoration-none">
                    <div class="card-body text-center py-3 px-2">
                        <div class="module-icon mx-auto mb-2" style="background:var(--purple-bg);color:var(--purple);">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="module-card-title">Clientes</div>
                        <div class="module-card-desc">Registro e información</div>
                    </div>
                </a>
            </div>
            <div class="col-6">
                <a href="{{ route('rooms.index') }}" class="card module-card h-100 text-decoration-none">
                    <div class="card-body text-center py-3 px-2">
                        <div class="module-icon mx-auto mb-2" style="background:var(--success-bg);color:var(--success);">
                            <i class="bi bi-door-open"></i>
                        </div>
                        <div class="module-card-title">Habitaciones</div>
                        <div class="module-card-desc">Tipos y estados</div>
                    </div>
                </a>
            </div>
            <div class="col-6">
                <a href="{{ route('reservations.index') }}" class="card module-card h-100 text-decoration-none">
                    <div class="card-body text-center py-3 px-2">
                        <div class="module-icon mx-auto mb-2" style="background:var(--warning-bg);color:var(--warning);">
                            <i class="bi bi-calendar2-check"></i>
                        </div>
                        <div class="module-card-title">Reservaciones</div>
                        <div class="module-card-desc">Crear y administrar</div>
                    </div>
                </a>
            </div>
            <div class="col-6">
                <a href="{{ route('checkins.index') }}" class="card module-card h-100 text-decoration-none">
                    <div class="card-body text-center py-3 px-2">
                        <div class="module-icon mx-auto mb-2" style="background:var(--success-bg);color:var(--success);">
                            <i class="bi bi-box-arrow-in-right"></i>
                        </div>
                        <div class="module-card-title">Check-In/Out</div>
                        <div class="module-card-desc">Registro de ingresos</div>
                    </div>
                </a>
            </div>
            <div class="col-6">
                <a href="{{ route('payments.index') }}" class="card module-card h-100 text-decoration-none">
                    <div class="card-body text-center py-3 px-2">
                        <div class="module-icon mx-auto mb-2" style="background:var(--danger-bg);color:var(--danger);">
                            <i class="bi bi-wallet2"></i>
                        </div>
                        <div class="module-card-title">Pagos</div>
                        <div class="module-card-desc">Transacciones</div>
                    </div>
                </a>
            </div>
            <div class="col-6">
                <a href="{{ route('reports.index') }}" class="card module-card h-100 text-decoration-none">
                    <div class="card-body text-center py-3 px-2">
                        <div class="module-icon mx-auto mb-2" style="background:var(--info-bg);color:var(--info);">
                            <i class="bi bi-bar-chart-line"></i>
                        </div>
                        <div class="module-card-title">Reportes</div>
                        <div class="module-card-desc">Estadísticas</div>
                    </div>
                </a>
            </div>
            <div class="col-6">
                <a href="{{ route('panel.index') }}" class="card module-card h-100 text-decoration-none">
                    <div class="card-body text-center py-3 px-2">
                        <div class="module-icon mx-auto mb-2" style="background:var(--surface-alt);color:var(--text-secondary);">
                            <i class="bi bi-sliders"></i>
                        </div>
                        <div class="module-card-title">Configuración</div>
                        <div class="module-card-desc">Ajustes del sistema</div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    {{-- Reservaciones Recientes --}}
    <div class="col-lg-7">
        <div class="section-header">
            <h5><i class="bi bi-calendar-week"></i> Reservaciones Recientes</h5>
            <a href="{{ route('reservations.index') }}" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-arrow-right me-1"></i>Ver todas
            </a>
        </div>
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Habitación</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Estado</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reservaciones_recientes as $r)
                            <tr>
                                <td>
                                    <div style="font-weight:600;">{{ $r->client->full_name ?? 'N/A' }}</div>
                                    @if($r->client && $r->client->email)
                                    <small style="color:var(--text-muted);">{{ $r->client->email }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span style="font-weight:500;">{{ $r->room->room_number ?? 'N/A' }}</span>
                                    @if($r->room && $r->room->roomType)
                                    <br><small style="color:var(--text-muted);">{{ $r->room->roomType->name }}</small>
                                    @endif
                                </td>
                                <td>{{ $r->check_in_date->format('d/m/Y') }}</td>
                                <td>{{ $r->check_out_date->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge-status badge-{{ $r->status }}">{{ ucfirst($r->status) }}</span>
                                </td>
                                <td class="text-end" style="font-weight:600;">${{ number_format($r->total_amount, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state py-4">
                                        <i class="bi bi-calendar-x d-block"></i>
                                        <h6>No hay reservaciones</h6>
                                        <p>Las reservaciones recientes aparecerán aquí.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
