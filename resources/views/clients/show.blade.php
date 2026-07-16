@extends('layouts.app')
@section('title', 'Detalle Cliente')
@section('page-title', 'Cliente: ' . $client->full_name)

@section('content')
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><h6 class="mb-0">Información Personal</h6></div>
            <div class="card-body">
                <p><strong>Nombre:</strong> {{ $client->full_name }}</p>
                <p><strong>Email:</strong> {{ $client->user->email }}</p>
                <p><strong>Teléfono:</strong> {{ $client->phone ?? '—' }}</p>
                <p><strong>Dirección:</strong> {{ $client->address ?? '—' }}</p>
                <p><strong>Ciudad:</strong> {{ $client->city ?? '—' }}</p>
                <p><strong>Documento:</strong> {{ $client->id_type }} {{ $client->id_number }}</p>
                <p><strong>Nacionalidad:</strong> {{ $client->nationality }}</p>
                <a href="{{ route('clients.edit', $client) }}" class="btn btn-sm btn-outline-primary mt-2"><i class="bi bi-pencil me-1"></i>Editar</a>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><h6 class="mb-0">Historial de Reservaciones</h6></div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light"><tr><th>Habitación</th><th>Check-in</th><th>Check-out</th><th>Total</th><th>Estado</th></tr></thead>
                        <tbody>
                            @forelse($client->reservations as $r)
                            <tr>
                                <td>{{ $r->room->room_number ?? 'N/A' }}</td>
                                <td>{{ $r->check_in_date->format('d/m/Y') }}</td>
                                <td>{{ $r->check_out_date->format('d/m/Y') }}</td>
                                <td>${{ number_format($r->total_amount, 2) }}</td>
                                <td><span class="badge bg-{{ $r->status=='completada'?'success':($r->status=='pendiente'?'warning':($r->status=='cancelada'?'danger':'info')) }}">{{ ucfirst($r->status) }}</span></td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted py-3">Sin reservaciones</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
