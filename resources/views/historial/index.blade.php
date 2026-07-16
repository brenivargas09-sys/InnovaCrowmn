@extends('layouts.app')
@section('title', 'Historial de Estados')
@section('page-title', 'Historial de Cambios de Estado')

@section('content')
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form class="row g-2 align-items-end" method="GET">
            <div class="col-md-3">
                <label class="form-label">Tipo</label>
                <select name="tipo" class="form-select form-select-sm">
                    <option value="">Todos</option>
                    <option value="reservacion" {{ request('tipo') == 'reservacion' ? 'selected' : '' }}>Reservación</option>
                    <option value="checkin" {{ request('tipo') == 'checkin' ? 'selected' : '' }}>Check-in</option>
                    <option value="checkout" {{ request('tipo') == 'checkout' ? 'selected' : '' }}>Check-out</option>
                    <option value="pago" {{ request('tipo') == 'pago' ? 'selected' : '' }}>Pago</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-sm btn-primary w-100"><i class="bi bi-funnel me-1"></i>Filtrar</button>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Registro</th>
                        <th>Estado Anterior</th>
                        <th>Estado Nuevo</th>
                        <th>Cambiado por</th>
                        <th>Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($historial as $h)
                    <tr>
                        <td>{{ $h->id }}</td>
                        <td>{{ $h->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            @php
                                $tipoColors = ['reservacion' => 'primary', 'checkin' => 'success', 'checkout' => 'warning', 'pago' => 'info'];
                            @endphp
                            <span class="badge bg-{{ $tipoColors[$h->tipo] ?? 'secondary' }}">{{ ucfirst($h->tipo) }}</span>
                        </td>
                        <td>#{{ $h->registro_id }}</td>
                        <td>{{ $h->estado_anterior ? ucfirst($h->estado_anterior) : '—' }}</td>
                        <td><span class="fw-bold">{{ ucfirst($h->estado_nuevo) }}</span></td>
                        <td>{{ $h->cambiadoPor->username ?? 'N/A' }}</td>
                        <td class="text-muted small">{{ $h->observaciones ?? '—' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center text-muted py-3">Sin registros de historial</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">
        {{ $historial->withQueryString()->links() }}
    </div>
</div>
@endsection
