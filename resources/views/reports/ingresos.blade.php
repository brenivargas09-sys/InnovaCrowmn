@extends('layouts.app')
@section('title', 'Reporte de Ingresos')
@section('page-title', 'Reporte de Ingresos')

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
    <div class="col-md"><div class="card card-stat text-center"><div class="card-body"><div class="text-muted small">Total Ingresos</div><h3 class="text-success">${{ number_format($stats['total'], 2) }}</h3></div></div></div>
    <div class="col-md"><div class="card card-stat text-center"><div class="card-body"><div class="text-muted small">Nº Pagos</div><h3>{{ $stats['count'] }}</h3></div></div></div>
    <div class="col-md"><div class="card card-stat text-center"><div class="card-body"><div class="text-muted small">Efectivo</div><h4>${{ number_format($stats['efectivo'], 2) }}</h4></div></div></div>
    <div class="col-md"><div class="card card-stat text-center"><div class="card-body"><div class="text-muted small">Tarjeta Crédito</div><h4>${{ number_format($stats['tarjeta_credito'], 2) }}</h4></div></div></div>
    <div class="col-md"><div class="card card-stat text-center"><div class="card-body"><div class="text-muted small">Tarjeta Débito</div><h4>${{ number_format($stats['tarjeta_debito'], 2) }}</h4></div></div></div>
    <div class="col-md"><div class="card card-stat text-center"><div class="card-body"><div class="text-muted small">Transferencia</div><h4>${{ number_format($stats['transferencia'], 2) }}</h4></div></div></div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><h6 class="mb-0">Distribución por Método de Pago</h6></div>
            <div class="card-body"><canvas id="chartMetodos" height="250"></canvas></div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><h6 class="mb-0">Ingresos Diarios</h6></div>
            <div class="card-body"><canvas id="chartDiario" height="250"></canvas></div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Detalle de Pagos</h6>
        <button onclick="window.print()" class="btn btn-sm btn-outline-secondary"><i class="bi bi-printer me-1"></i>Imprimir</button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light"><tr><th>#</th><th>Reservación</th><th>Cliente</th><th>Habitación</th><th>Monto</th><th>Método</th><th>Fecha</th><th>Referencia</th></tr></thead>
                <tbody>
                    @forelse($payments as $p)
                    <tr>
                        <td>{{ $p->id }}</td>
                        <td>#{{ $p->reservation_id }}</td>
                        <td>{{ $p->reservation->client->full_name ?? 'N/A' }}</td>
                        <td>{{ $p->reservation->room->room_number ?? 'N/A' }}</td>
                        <td class="text-success fw-bold">${{ number_format($p->amount, 2) }}</td>
                        <td><span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $p->payment_method)) }}</span></td>
                        <td>{{ $p->payment_date->format('d/m/Y') }}</td>
                        <td>{{ $p->reference_number ?? '—' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center text-muted py-3">Sin pagos en el período</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    new Chart(document.getElementById('chartMetodos'), {
        type: 'pie',
        data: {
            labels: ['Efectivo', 'Tarjeta Crédito', 'Tarjeta Débito', 'Transferencia'],
            datasets: [{
                data: [{{ $stats['efectivo'] }}, {{ $stats['tarjeta_credito'] }}, {{ $stats['tarjeta_debito'] }}, {{ $stats['transferencia'] }}],
                backgroundColor: ['#198754', '#0d6efd', '#6f42c1', '#fd7e14'],
            }]
        },
        options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
    });

    const dias = @json($ingresosDiarios->pluck('dia'));
    const montos = @json($ingresosDiarios->pluck('total'));
    new Chart(document.getElementById('chartDiario'), {
        type: 'line',
        data: {
            labels: dias,
            datasets: [{
                label: 'Ingresos ($)',
                data: montos,
                borderColor: '#c9a96e',
                backgroundColor: 'rgba(201,169,110,0.1)',
                fill: true,
                tension: 0.3,
            }]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });
</script>
@endpush
@endsection
