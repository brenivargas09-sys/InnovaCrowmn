@extends('layouts.app')
@section('title', 'Reservaciones')
@section('page-title', 'Gestión de Reservaciones')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Reservaciones</h6>
        @if(auth()->user()->role !== 'cliente')
        <a href="{{ route('reservations.create') }}" class="btn btn-sm btn-primary"><i class="bi bi-plus-circle me-1"></i>Nueva</a>
        @endif
    </div>
    <div class="card-body">
        <form class="row g-2 mb-3" method="GET">
            <div class="col-md-4"><input type="text" name="search" class="form-control form-control-sm" placeholder="Buscar cliente..." value="{{ request('search') }}"></div>
            <div class="col-md-3">
                <select name="status" class="form-select form-select-sm">
                    <option value="">Todos</option>
                    @foreach(['pendiente','confirmada','cancelada','completada'] as $s)<option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>{{ ucfirst($s) }}</option>@endforeach
                </select>
            </div>
            <div class="col-md-2"><button class="btn btn-sm btn-primary w-100">Filtrar</button></div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light"><tr><th>#</th><th>Cliente</th><th>Habitación</th><th>Check-in</th><th>Check-out</th><th>Total</th><th>Estado</th><th>Acciones</th></tr></thead>
                <tbody>
                    @forelse($reservations as $r)
                    <tr>
                        <td>{{ $r->id }}</td>
                        <td>{{ $r->client->full_name ?? 'N/A' }}</td>
                        <td>{{ $r->room->room_number ?? 'N/A' }} <small>({{ $r->room->roomType->name ?? '' }})</small></td>
                        <td>{{ $r->check_in_date->format('d/m/Y') }}</td>
                        <td>{{ $r->check_out_date->format('d/m/Y') }}</td>
                        <td>${{ number_format($r->total_amount, 2) }}</td>
                        <td><span class="badge bg-{{ ['pendiente'=>'warning','confirmada'=>'info','cancelada'=>'danger','completada'=>'success'][$r->status] ?? 'secondary' }}">{{ ucfirst($r->status) }}</span></td>
                        <td>
                            <a href="{{ route('reservations.show', $r) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                            @if(auth()->user()->role !== 'cliente')
                            <a href="{{ route('reservations.edit', $r) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('reservations.destroy', $r) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?')">
                                @csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center text-muted">No hay reservaciones</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $reservations->withQueryString()->links() }}
    </div>
</div>
@endsection
