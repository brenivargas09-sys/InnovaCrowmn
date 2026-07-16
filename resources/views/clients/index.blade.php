@extends('layouts.app')
@section('title', 'Clientes')
@section('page-title', 'Gestión de Clientes')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Clientes del Hotel</h6>
        <a href="{{ route('clients.create') }}" class="btn btn-sm btn-primary"><i class="bi bi-plus-circle me-1"></i>Nuevo</a>
    </div>
    <div class="card-body">
        <form class="row g-2 mb-3" method="GET">
            <div class="col-md-5"><input type="text" name="search" class="form-control form-control-sm" placeholder="Buscar por nombre, ID, teléfono..." value="{{ request('search') }}"></div>
            <div class="col-md-2"><button class="btn btn-sm btn-primary w-100">Buscar</button></div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light"><tr><th>ID</th><th>Nombre</th><th>Teléfono</th><th>Ciudad</th><th>Documento</th><th>Acciones</th></tr></thead>
                <tbody>
                    @forelse($clients as $client)
                    <tr>
                        <td>{{ $client->id }}</td>
                        <td><strong>{{ $client->full_name }}</strong><br><small class="text-muted">{{ $client->email ?? $client->user->email }}</small></td>
                        <td>{{ $client->phone ?? '—' }}</td>
                        <td>{{ $client->city ?? '—' }}</td>
                        <td><small>{{ $client->id_type }}: {{ $client->id_number }}</small></td>
                        <td>
                            <a href="{{ route('clients.show', $client) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('clients.edit', $client) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('clients.destroy', $client) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted">No hay clientes</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $clients->withQueryString()->links() }}
    </div>
</div>
@endsection
