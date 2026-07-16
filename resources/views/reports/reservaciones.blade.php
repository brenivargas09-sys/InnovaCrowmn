@extends('layouts.app')
@section('title', 'Reporte de Reservaciones')
@section('page-title', 'Reporte de Reservaciones')

@section('content')
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form class="row g-2 align-items-end" method="GET">
            <div class="col-md-3"><label class="form-label">Desde</label><input type="date" name="from" class="form-control form-control-sm" value="{{ $from }}"></div>
            <div class="col-md-3"><label class="form-label">Hasta</label><input type="date" name="to" class="form-control form-control-sm" value="{{ $to }}"></div>
            <div class="col-md-2"><button class="btn btn-sm btn-primary w-100"><i class="bi bi-funnel me-1"></i>Filtrar</button></div>
        </form>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md"><div class="card card-stat text-center"><div class="card-body"><div class="text-muted small">Total</div><h3>{{ $stats['total'] }}</h3></div></div></div>
    <div class="col-md"><div class="card card-stat text-center"><div class="card-body"><div class="text-muted small">Completadas</div><h3 class="text-success">{{ $stats['completadas'] }}</h3></div></div></div>
    <div class="col-md"><div class="card card-stat text-center"><div class="card-body"><div class="text-muted small">Pendientes</div><h3 class="text-warning">{{ $stats['pendientes'] }}</h3></div></div></div>
    <div class="col-md"><div class="card card-stat text-center"><div class="card-body"><div class="text-muted small">Canceladas</div><h3 class="text-danger">{{ $stats['canceladas'] }}</h3></div></div></div>
    <div class="col-md"><div class="card card-stat text-center"><div class="card-body"><div class="text-muted small">Ingresos</div><h3 class="text-primary">${{ number_format($stats['ingresos'], 2) }}</h3></div></div></div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><h6 class="mb-0">Distribución por Estado</h6></div>
            <div class="card-body"><canvas id="chartEstados" height="250"></canvas></div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><h6 class="mb-0">Ingresos por Semana</h6></div>
            <div class="card-body"><canvas id="chartIngresos" height="250"></canvas></div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Detalle de Reservaciones</h6>
        <button onclick="window.print()" class="btn btn-sm btn-outline-secondary"><i class="bi bi-printer me-1"></i>Imprimir</button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light"><tr><th>#</th><th>Cliente</th><th>Habitación</th><th>Check-in</th><th>Check-out</th><th>Noches</th><th>Total</th><th>Estado</th></tr></thead>
                <tbody>
                    @forelse($reservations as $r)
                    <tr>
                        <td>{{ $r->id }}</td>
                        <td>{{ $r->client->full_name ?? 'N/A' }}</td>
                        <td>{{ $r->room->room_number ?? 'N/A' }}</td>
                        <td>{{ $r->check_in_date->format('d/m/Y') }}</td>
                        <td>{{ $r->check_out_date->format('d/m/Y') }}</td>
                        <td>{{ $r->check_in_date->diffInDays($r->check_out_date) }}</td>
                        <td>${{ number_format($r->total_amount, 2) }}</td>
                        <td><span class="badge bg-{{ ['pendiente'=>'warning','confirmada'=>'info','cancelada'=>'danger','completada'=>'success'][$r->status] ?? 'secondary' }}">{{ ucfirst($r->status) }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center text-muted py-3">Sin datos para el período</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    new Chart(document.getElementById('chartEstados'), {
        type: 'doughnut',
        data: {
            labels: ['Completadas', 'Pendientes', 'Canceladas'],
            datasets: [{
                data: [{{ $stats['completadas'] }}, {{ $stats['pendientes'] }}, {{ $stats['canceladas'] }}],
                backgroundColor: ['#198754', '#ffc107', '#dc3545'],
            }]
        },
        options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
    });

    const ingresosLabels = @json($ingresosSemanal->pluck('semana'));
    const ingresosData = @json($ingresosSemanal->pluck('total'));
    new Chart(document.getElementById('chartIngresos'), {
        type: 'bar',
        data: {
            labels: ingresosLabels,
            datasets: [{
                label: 'Ingresos ($)',
                data: ingresosData,
                backgroundColor: '#1a1a2e',
                borderColor: '#c9a96e',
                borderWidth: 1,
                borderRadius: 6,
            }]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });
</script>
@endpush
@endsection
