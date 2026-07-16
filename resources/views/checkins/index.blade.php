@extends('layouts.app')
@section('title', 'Check-In / Check-Out')
@section('page-title', 'Check-In / Check-Out')

@section('content')
<div class="row g-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><h6 class="mb-0"><i class="bi bi-box-arrow-in-right text-success me-2"></i>Check-In Pendientes</h6></div>
            <div class="card-body">
                @forelse($pendientes as $r)
                <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                    <div>
                        <strong>{{ $r->room->room_number }}</strong> - {{ $r->room->roomType->name ?? '' }}
                        <br><small class="text-muted">{{ $r->client->full_name ?? 'N/A' }} | Check-in: {{ $r->check_in_date->format('d/m/Y') }}</small>
                    </div>
                    <form action="{{ route('checkins.checkin', $r) }}" method="POST" onsubmit="return confirm('¿Confirmar check-in?')">
                        @csrf
                        <button class="btn btn-sm btn-success"><i class="bi bi-check-circle me-1"></i>Check-In</button>
                    </form>
                </div>
                @empty
                <div class="text-center text-muted py-4">No hay check-ins pendientes</div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><h6 class="mb-0"><i class="bi bi-box-arrow-right text-warning me-2"></i>Check-Outs Pendientes (Hoy)</h6></div>
            <div class="card-body">
                @forelse($checkoutsHoy as $c)
                <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                    <div>
                        <strong>{{ $c->reservation->room->room_number ?? 'N/A' }}</strong>
                        <br><small class="text-muted">{{ $c->reservation->client->full_name ?? 'N/A' }} | Check-in: {{ $c->actual_check_in ? $c->actual_check_in->format('d/m/Y H:i') : '—' }}</small>
                    </div>
                    <form action="{{ route('checkins.checkout', $c) }}" method="POST" onsubmit="return confirm('¿Confirmar check-out?')">
                        @csrf
                        <button class="btn btn-sm btn-warning"><i class="bi bi-box-arrow-right me-1"></i>Check-Out</button>
                    </form>
                </div>
                @empty
                <div class="text-center text-muted py-4">No hay check-outs pendientes hoy</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mt-4">
    <div class="card-header bg-white"><h6 class="mb-0">Check-ins de Hoy</h6></div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light"><tr><th>Habitación</th><th>Cliente</th><th>Check-in</th><th>Check-out</th><th>Notas</th></tr></thead>
                <tbody>
                    @forelse($checkinsHoy as $c)
                    <tr>
                        <td>{{ $c->reservation->room->room_number ?? 'N/A' }}</td>
                        <td>{{ $c->reservation->client->full_name ?? 'N/A' }}</td>
                        <td>{{ $c->actual_check_in ? $c->actual_check_in->format('H:i') : '—' }}</td>
                        <td>{{ $c->actual_check_out ? $c->actual_check_out->format('H:i') : 'Pendiente' }}</td>
                        <td>{{ $c->notes ?? '—' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted py-3">Sin registros hoy</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
