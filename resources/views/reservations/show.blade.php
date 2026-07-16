@extends('layouts.app')
@section('title', 'Reservación #' . $reservation->id)
@section('page-title', 'Reservación #' . $reservation->id)

@section('content')
<div class="row g-4">
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between">
                <h6 class="mb-0">Detalles de Reservación</h6>
                <a href="{{ route('reservations.edit', $reservation) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
            </div>
            <div class="card-body">
                <p><strong>Cliente:</strong> {{ $reservation->client->full_name ?? 'N/A' }}</p>
                <p><strong>Habitación:</strong> {{ $reservation->room->room_number ?? 'N/A' }} ({{ $reservation->room->roomType->name ?? '' }})</p>
                <p><strong>Check-in:</strong> {{ $reservation->check_in_date->format('d/m/Y') }}</p>
                <p><strong>Check-out:</strong> {{ $reservation->check_out_date->format('d/m/Y') }}</p>
                <p><strong>Noches:</strong> {{ $reservation->nights }}</p>
                <hr>
                <p><strong>Alojamiento:</strong> <span class="text-primary">${{ number_format($reservation->total_amount, 2) }}</span></p>
                <p><strong>Servicios:</strong> <span class="text-info">${{ number_format($reservation->total_services, 2) }}</span></p>
                <p><strong>Total General:</strong> <span class="text-success fw-bold fs-5">${{ number_format($reservation->grand_total, 2) }}</span></p>
                <p><strong>Estado:</strong> <span class="badge bg-{{ ['pendiente'=>'warning','confirmada'=>'info','cancelada'=>'danger','completada'=>'success'][$reservation->status] }}">{{ ucfirst($reservation->status) }}</span></p>
                <p><strong>Creado por:</strong> {{ $reservation->createdBy->username ?? 'N/A' }}</p>
                @if($reservation->notes)<p><strong>Notas:</strong> {{ $reservation->notes }}</p>@endif
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Servicios Consumidos</h6>
                <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                    <i class="bi bi-plus-circle"></i> Agregar
                </button>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light"><tr><th>Servicio</th><th>Cant.</th><th>Precio Unit.</th><th>Subtotal</th><th>Acciones</th></tr></thead>
                    <tbody>
                        @forelse($reservation->reservationServices as $rs)
                        <tr>
                            <td>{{ $rs->service->name ?? 'N/A' }}</td>
                            <td>{{ $rs->quantity }}</td>
                            <td>${{ number_format($rs->service->price ?? 0, 2) }}</td>
                            <td class="text-info fw-bold">${{ number_format($rs->subtotal, 2) }}</td>
                            <td>
                                <form action="{{ route('reservations.services.destroy', [$reservation, $rs]) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Remover este servicio?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-3">Sin servicios registrados</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white"><h6 class="mb-0">Check-ins / Check-outs</h6></div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light"><tr><th>Check-in</th><th>Check-out</th><th>Notas</th><th>Por</th></tr></thead>
                    <tbody>
                        @forelse($reservation->checkins as $c)
                        <tr>
                            <td>{{ $c->actual_check_in ? $c->actual_check_in->format('d/m/Y H:i') : '—' }}</td>
                            <td>{{ $c->actual_check_out ? $c->actual_check_out->format('d/m/Y H:i') : 'Pendiente' }}</td>
                            <td>{{ $c->notes ?? '—' }}</td>
                            <td>{{ $c->createdBy->username ?? 'N/A' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted py-3">Sin registros</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><h6 class="mb-0">Pagos</h6></div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light"><tr><th>Monto</th><th>Método</th><th>Fecha</th><th>Referencia</th><th>Por</th></tr></thead>
                    <tbody>
                        @forelse($reservation->payments as $p)
                        <tr>
                            <td class="text-success">${{ number_format($p->amount, 2) }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $p->payment_method)) }}</td>
                            <td>{{ $p->payment_date->format('d/m/Y') }}</td>
                            <td>{{ $p->reference_number ?? '—' }}</td>
                            <td>{{ $p->createdBy->username ?? 'N/A' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-3">Sin pagos registrados</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addServiceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('reservations.services.store', $reservation) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Servicio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Servicio</label>
                        <select name="service_id" class="form-select" required>
                            <option value="">Seleccionar...</option>
                            @foreach(\App\Models\Service::where('status', 'activo')->get() as $s)
                                <option value="{{ $s->id }}">{{ $s->name }} - ${{ number_format($s->price, 2) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cantidad</label>
                        <input type="number" name="quantity" class="form-control" value="1" min="1" max="99" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notas</label>
                        <input type="text" name="notes" class="form-control" maxlength="200">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Agregar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
