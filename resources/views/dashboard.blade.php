@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card-stat">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:linear-gradient(135deg,#dbeafe,#bfdbfe);color:#2563eb"><i class="bi bi-door-open"></i></div>
                <div><div class="stat-label">Habitaciones</div><div class="stat-value">{{ $stats['habitaciones_total'] }}</div></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card-stat">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:linear-gradient(135deg,#dcfce7,#bbf7d0);color:#16a34a"><i class="bi bi-check-circle"></i></div>
                <div><div class="stat-label">Disponibles</div><div class="stat-value">{{ $stats['habitaciones_disponibles'] }}</div></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card-stat">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:linear-gradient(135deg,#fef3c7,#fde68a);color:#d97706"><i class="bi bi-person-check"></i></div>
                <div><div class="stat-label">Ocupadas</div><div class="stat-value">{{ $stats['habitaciones_ocupadas'] }}</div></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card-stat">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:linear-gradient(135deg,#e0f2fe,#bae6fd);color:#0284c7"><i class="bi bi-calendar"></i></div>
                <div><div class="stat-label">Reservadas</div><div class="stat-value">{{ $stats['habitaciones_reservadas'] }}</div></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card-stat">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:linear-gradient(135deg,#fce7f3,#fbcfe8);color:#db2777"><i class="bi bi-currency-dollar"></i></div>
                <div><div class="stat-label">Ingresos del Mes</div><div class="stat-value">${{ number_format($stats['ingresos_mes'], 2) }}</div></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card-stat">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:linear-gradient(135deg,#d1fae5,#a7f3d0);color:#059669"><i class="bi bi-arrow-down-circle"></i></div>
                <div><div class="stat-label">Check-ins Hoy</div><div class="stat-value">{{ $stats['reservaciones_hoy'] }}</div></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card-stat">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:linear-gradient(135deg,#fef3c7,#fde68a);color:#d97706"><i class="bi bi-arrow-up-circle"></i></div>
                <div><div class="stat-label">Check-outs Hoy</div><div class="stat-value">{{ $stats['checkouts_hoy'] }}</div></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card-stat">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:linear-gradient(135deg,#ede9fe,#ddd6fe);color:#7c3aed"><i class="bi bi-people"></i></div>
                <div><div class="stat-label">Total Clientes</div><div class="stat-value">{{ $stats['total_clientes'] }}</div></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="bi bi-calendar-week text-accent me-2"></i>Reservaciones Recientes</h6>
                <a href="{{ route('reservations.index') }}" class="btn btn-sm btn-outline-primary">Ver todas</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr><th>Cliente</th><th>Habitación</th><th>Check-in</th><th>Check-out</th><th>Estado</th><th>Total</th></tr>
                        </thead>
                        <tbody>
                            @forelse($reservaciones_recientes as $r)
                            <tr>
                                <td>{{ $r->client->full_name ?? 'N/A' }}</td>
                                <td>{{ $r->room->room_number ?? 'N/A' }} <small class="text-muted">({{ $r->room->roomType->name ?? '' }})</small></td>
                                <td>{{ $r->check_in_date->format('d/m/Y') }}</td>
                                <td>{{ $r->check_out_date->format('d/m/Y') }}</td>
                                <td>
                                    @php
                                        $colors = ['pendiente' => 'warning', 'confirmada' => 'info', 'cancelada' => 'danger', 'completada' => 'success'];
                                    @endphp
                                    <span class="badge bg-{{ $colors[$r->status] ?? 'secondary' }}">{{ ucfirst($r->status) }}</span>
                                </td>
                                <td>${{ number_format($r->total_amount, 2) }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center text-muted py-4">No hay reservaciones recientes</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-white"><h6 class="mb-0"><i class="bi bi-lightning text-accent me-2"></i>Accesos Rápidos</h6></div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('reservations.create') }}" class="btn btn-outline-primary text-start"><i class="bi bi-plus-circle me-2"></i>Nueva Reservación</a>
                    <a href="{{ route('checkins.index') }}" class="btn btn-outline-success text-start"><i class="bi bi-box-arrow-in-right me-2"></i>Check-In / Check-Out</a>
                    <a href="{{ route('payments.create') }}" class="btn btn-outline-info text-start"><i class="bi bi-cash me-2"></i>Registrar Pago</a>
                    <a href="{{ route('clients.create') }}" class="btn btn-outline-secondary text-start"><i class="bi bi-person-plus me-2"></i>Nuevo Cliente</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
