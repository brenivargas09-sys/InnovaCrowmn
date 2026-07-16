@extends('layouts.app')
@section('title', 'Servicios')
@section('page-title', 'Gestión de Servicios')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Servicios del Hotel</h6>
        <a href="{{ route('services.create') }}" class="btn btn-sm btn-primary"><i class="bi bi-plus-circle me-1"></i>Nuevo</a>
    </div>
    <div class="card-body">
        <form class="row g-2 mb-3" method="GET">
            <div class="col-md-5"><input type="text" name="search" class="form-control form-control-sm" placeholder="Buscar por nombre..." value="{{ $search ?? '' }}"></div>
            <div class="col-md-2"><button class="btn btn-sm btn-primary w-100">Buscar</button></div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light"><tr><th>ID</th><th>Nombre</th><th>Descripción</th><th>Precio</th><th>Estado</th><th>Acciones</th></tr></thead>
                <tbody>
                    @forelse($services as $s)
                    <tr>
                        <td>{{ $s->id }}</td>
                        <td><strong>{{ $s->name }}</strong></td>
                        <td>{{ Str::limit($s->description, 50) ?? '—' }}</td>
                        <td>${{ number_format($s->price, 2) }}</td>
                        <td><span class="badge bg-{{ $s->status=='activo'?'success':'secondary' }}">{{ ucfirst($s->status) }}</span></td>
                        <td>
                            <a href="{{ route('services.show', $s) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('services.edit', $s) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('services.destroy', $s) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?')">
                                @csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted">No hay servicios</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $services->links() }}
    </div>
</div>
@endsection
