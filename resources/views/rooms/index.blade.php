@extends('layouts.app')
@section('title', 'Habitaciones')
@section('page-title', 'Gestión de Habitaciones')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Habitaciones</h6>
        <a href="{{ route('rooms.create') }}" class="btn btn-sm btn-primary"><i class="bi bi-plus-circle me-1"></i>Nueva</a>
    </div>
    <div class="card-body">
        <form class="row g-2 mb-3" method="GET">
            <div class="col-md-2"><input type="text" name="search" class="form-control form-control-sm" placeholder="Nº Hab." value="{{ request('search') }}"></div>
            <div class="col-md-2">
                <select name="status" class="form-select form-select-sm">
                    <option value="">Todos</option>
                    @foreach(['disponible','reservada','ocupada','mantenimiento'] as $s)
                    <option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="floor" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">Todos los pisos</option>
                    @for($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}" {{ request('floor') == $i ? 'selected' : '' }}>Piso {{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2"><select name="room_type_id" class="form-select form-select-sm"><option value="">Todos tipos</option>@foreach($roomTypes as $t)<option value="{{ $t->id }}" {{ request('room_type_id')==$t->id?'selected':'' }}>{{ $t->name }}</option>@endforeach</select></div>
            <div class="col-md-1"><button class="btn btn-sm btn-primary w-100">Filtrar</button></div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light"><tr><th>Nº</th><th>Tipo</th><th>Piso</th><th>Precio/Noche</th><th>Estado</th><th>Acciones</th></tr></thead>
                <tbody>
                    @forelse($rooms as $room)
                    <tr>
                        <td><strong>{{ $room->room_number }}</strong></td>
                        <td>{{ $room->roomType->name ?? 'N/A' }}</td>
                        <td>{{ $room->floor }}</td>
                        <td>${{ number_format($room->roomType->price_per_night ?? 0, 2) }}</td>
                        <td>
                            @php $sc = ['disponible'=>'success','reservada'=>'info','ocupada'=>'warning','mantenimiento'=>'danger']; @endphp
                            <span class="badge bg-{{ $sc[$room->status] ?? 'secondary' }}">{{ ucfirst($room->status) }}</span>
                        </td>
                        <td>
                            <a href="{{ route('rooms.show', $room) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('rooms.edit', $room) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('rooms.destroy', $room) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted">No hay habitaciones</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $rooms->withQueryString()->links() }}
    </div>
</div>
@endsection
