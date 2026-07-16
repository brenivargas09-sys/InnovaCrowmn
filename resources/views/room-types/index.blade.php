@extends('layouts.app')
@section('title', 'Tipos de Habitación')
@section('page-title', 'Tipos de Habitación')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Tipos de Habitación</h6>
        <a href="{{ route('room-types.create') }}" class="btn btn-sm btn-primary"><i class="bi bi-plus-circle me-1"></i>Nuevo</a>
    </div>
    <div class="card-body p-0">
        <div class="px-3 pt-3">
            <form method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Buscar por nombre..." value="{{ $search ?? '' }}">
                    <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
                    @if(!empty($search))
                        <a href="{{ route('room-types.index') }}" class="btn btn-outline-danger"><i class="bi bi-x-lg"></i></a>
                    @endif
                </div>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light"><tr><th>ID</th><th>Nombre</th><th>Capacidad</th><th>Precio/Noche</th><th>Habitaciones</th><th>Acciones</th></tr></thead>
                <tbody>
                    @forelse($roomTypes as $rt)
                    <tr>
                        <td>{{ $rt->id }}</td>
                        <td><strong>{{ $rt->name }}</strong><br><small class="text-muted">{{ Str::limit($rt->description, 60) }}</small></td>
                        <td>{{ $rt->capacity }} pers.</td>
                        <td>${{ number_format($rt->price_per_night, 2) }}</td>
                        <td><span class="badge bg-secondary">{{ $rt->rooms_count }}</span></td>
                        <td>
                            <a href="{{ route('room-types.edit', $rt) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('room-types.destroy', $rt) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?')">
                                @csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted">No hay tipos</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
