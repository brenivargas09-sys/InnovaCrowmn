@extends('layouts.app')
@section('title', 'Habitación ' . $room->room_number)
@section('page-title', 'Habitación ' . $room->room_number)

@section('content')
<div class="row g-4">
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between"><h6 class="mb-0">Detalles</h6><a href="{{ route('rooms.edit', $room) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a></div>
            <div class="card-body">
                <p><strong>Número:</strong> {{ $room->room_number }}</p>
                <p><strong>Tipo:</strong> {{ $room->roomType->name ?? 'N/A' }}</p>
                <p><strong>Piso:</strong> {{ $room->floor }}</p>
                <p><strong>Precio/Noche:</strong> ${{ number_format($room->roomType->price_per_night ?? 0, 2) }}</p>
                <p><strong>Capacidad:</strong> {{ $room->roomType->capacity ?? 'N/A' }} personas</p>
                <p><strong>Estado:</strong> <span class="badge bg-{{ ['disponible'=>'success','reservada'=>'info','ocupada'=>'warning','mantenimiento'=>'danger'][$room->status] }}">{{ ucfirst($room->status) }}</span></p>
                <p><strong>Descripción:</strong> {{ $room->description ?? '—' }}</p>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><h6 class="mb-0">Historial de Reservaciones</h6></div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light"><tr><th>Cliente</th><th>Check-in</th><th>Check-out</th><th>Total</th><th>Estado</th></tr></thead>
                        <tbody>
                            @forelse($reservaciones as $r)
                            <tr>
                                <td>{{ $r->client->full_name ?? 'N/A' }}</td>
                                <td>{{ $r->check_in_date->format('d/m/Y') }}</td>
                                <td>{{ $r->check_out_date->format('d/m/Y') }}</td>
                                <td>${{ number_format($r->total_amount, 2) }}</td>
                                <td><span class="badge bg-{{ $r->status=='completada'?'success':($r->status=='pendiente'?'warning':'info') }}">{{ ucfirst($r->status) }}</span></td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted py-3">Sin historial</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
