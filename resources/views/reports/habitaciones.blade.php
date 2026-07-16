@extends('layouts.app')
@section('title', 'Reporte de Habitaciones')
@section('page-title', 'Reporte de Habitaciones')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md"><div class="card card-stat text-center"><div class="card-body"><div class="text-muted small">Total</div><h3>{{ $stats['total'] }}</h3></div></div></div>
    <div class="col-md"><div class="card card-stat text-center"><div class="card-body"><div class="text-muted small">Disponibles</div><h3 class="text-success">{{ $stats['disponibles'] }}</h3></div></div></div>
    <div class="col-md"><div class="card card-stat text-center"><div class="card-body"><div class="text-muted small">Ocupadas</div><h3 class="text-warning">{{ $stats['ocupadas'] }}</h3></div></div></div>
    <div class="col-md"><div class="card card-stat text-center"><div class="card-body"><div class="text-muted small">Reservadas</div><h3 class="text-info">{{ $stats['reservadas'] }}</h3></div></div></div>
    <div class="col-md"><div class="card card-stat text-center"><div class="card-body"><div class="text-muted small">Mantenimiento</div><h3 class="text-danger">{{ $stats['mantenimiento'] }}</h3></div></div></div>
    <div class="col-md"><div class="card card-stat text-center"><div class="card-body"><div class="text-muted small">Ocupación</div><h3>{{ $stats['ocupacion_pct'] }}%</h3></div></div></div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><h6 class="mb-0">Estado de Habitaciones</h6></div>
            <div class="card-body"><canvas id="chartEstados" height="280"></canvas></div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><h6 class="mb-0">Distribución por Tipo</h6></div>
            <div class="card-body"><canvas id="chartTipos" height="280"></canvas></div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Detalle de Habitaciones</h6>
        <button onclick="window.print()" class="btn btn-sm btn-outline-secondary"><i class="bi bi-printer me-1"></i>Imprimir</button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light"><tr><th>Nº</th><th>Tipo</th><th>Piso</th><th>Precio/Noche</th><th>Estado</th></tr></thead>
                <tbody>
                    @foreach($rooms as $room)
                    <tr>
                        <td><strong>{{ $room->room_number }}</strong></td>
                        <td>{{ $room->roomType->name ?? 'N/A' }}</td>
                        <td>{{ $room->floor }}</td>
                        <td>${{ number_format($room->roomType->price_per_night ?? 0, 2) }}</td>
                        <td><span class="badge bg-{{ ['disponible'=>'success','reservada'=>'info','ocupada'=>'warning','mantenimiento'=>'danger'][$room->status] ?? 'secondary' }}">{{ ucfirst($room->status) }}</span></td>
                    </tr>
                    @endforeach
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
            labels: ['Disponibles', 'Ocupadas', 'Reservadas', 'Mantenimiento'],
            datasets: [{
                data: [{{ $stats['disponibles'] }}, {{ $stats['ocupadas'] }}, {{ $stats['reservadas'] }}, {{ $stats['mantenimiento'] }}],
                backgroundColor: ['#198754', '#ffc107', '#0dcaf0', '#dc3545'],
            }]
        },
        options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
    });

    const tipos = @json($tiposData->pluck('tipo'));
    const cantidades = @json($tiposData->pluck('cantidad'));
    new Chart(document.getElementById('chartTipos'), {
        type: 'bar',
        data: {
            labels: tipos,
            datasets: [{
                label: 'Habitaciones',
                data: cantidades,
                backgroundColor: ['#1a1a2e', '#c9a96e', '#16213e', '#e94560', '#0f3460', '#533483'],
                borderRadius: 6,
            }]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }, plugins: { legend: { display: false } } }
    });
</script>
@endpush
@endsection
