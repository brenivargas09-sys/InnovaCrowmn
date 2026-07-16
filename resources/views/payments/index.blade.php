@extends('layouts.app')
@section('title', 'Pagos')
@section('page-title', 'Gestión de Pagos')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Pagos Registrados</h6>
        <a href="{{ route('payments.create') }}" class="btn btn-sm btn-primary"><i class="bi bi-plus-circle me-1"></i>Nuevo Pago</a>
    </div>
    <div class="card-body">
        <form class="row g-2 mb-3" method="GET">
            <div class="col-md-4"><input type="text" name="search" class="form-control form-control-sm" placeholder="Buscar referencia..." value="{{ request('search') }}"></div>
            <div class="col-md-3">
                <select name="method" class="form-select form-select-sm">
                    <option value="">Todos los métodos</option>
                    @foreach(['efectivo','tarjeta_credito','tarjeta_debito','transferencia'] as $m)
                    <option value="{{ $m }}" {{ request('method')==$m?'selected':'' }}>{{ ucfirst(str_replace('_',' ',$m)) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2"><button class="btn btn-sm btn-primary w-100">Filtrar</button></div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light"><tr><th>#</th><th>Reservación</th><th>Cliente</th><th>Monto</th><th>Método</th><th>Fecha</th><th>Referencia</th><th>Acciones</th></tr></thead>
                <tbody>
                    @forelse($payments as $p)
                    <tr>
                        <td>{{ $p->id }}</td>
                        <td>#{{ $p->reservation_id }}</td>
                        <td>{{ $p->reservation->client->full_name ?? 'N/A' }}</td>
                        <td class="text-success fw-bold">${{ number_format($p->amount, 2) }}</td>
                        <td><span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $p->payment_method)) }}</span></td>
                        <td>{{ $p->payment_date->format('d/m/Y') }}</td>
                        <td>{{ $p->reference_number ?? '—' }}</td>
                        <td>
                            <a href="{{ route('payments.show', $p) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('payments.edit', $p) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('payments.destroy', $p) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?')">
                                @csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center text-muted">No hay pagos</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $payments->withQueryString()->links() }}
    </div>
</div>
@endsection
