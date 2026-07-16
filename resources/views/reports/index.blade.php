@extends('layouts.app')
@section('title', 'Reportes')
@section('page-title', 'Centro de Reportes')

@section('content')
<div class="row g-4">
    <div class="col-md-4">
        <a href="{{ route('reports.reservaciones') }}" class="card border-0 shadow-sm text-decoration-none card-stat">
            <div class="card-body text-center py-5">
                <i class="bi bi-calendar-check display-4 text-primary"></i>
                <h5 class="mt-3 text-dark">Reservaciones</h5>
                <p class="text-muted small">Reporte de reservaciones por período</p>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('reports.habitaciones') }}" class="card border-0 shadow-sm text-decoration-none card-stat">
            <div class="card-body text-center py-5">
                <i class="bi bi-door-open display-4 text-success"></i>
                <h5 class="mt-3 text-dark">Habitaciones</h5>
                <p class="text-muted small">Estado y ocupación de habitaciones</p>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('reports.ingresos') }}" class="card border-0 shadow-sm text-decoration-none card-stat">
            <div class="card-body text-center py-5">
                <i class="bi bi-cash-stack display-4 text-warning"></i>
                <h5 class="mt-3 text-dark">Ingresos</h5>
                <p class="text-muted small">Reporte de ingresos y pagos</p>
            </div>
        </a>
    </div>
</div>
@endsection
