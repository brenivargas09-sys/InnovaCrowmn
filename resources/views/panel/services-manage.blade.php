@extends('layouts.app')
@section('title', 'Gestionar Servicios')
@section('page-title', 'Gestionar Servicios')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="bi bi-concierge-bell text-accent me-2"></i>Agregar Nuevo Servicio</h6>
                <a href="{{ route('panel.index') }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-arrow-left me-1"></i>Volver</a>
            </div>
            <div class="card-body">
                <form action="{{ route('panel.services.store') }}" method="POST">
                    @csrf
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="name" class="form-control" required placeholder="Ej: Spa, Restaurante...">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Descripción</label>
                            <input type="text" name="description" class="form-control" placeholder="Descripción breve">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Precio</label>
                            <input type="number" name="price" class="form-control" step="0.01" min="0" required placeholder="$0.00">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Estado</label>
                            <select name="status" class="form-select">
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary w-100"><i class="bi bi-plus-lg"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-list-check text-accent me-2"></i>Servicios Existentes</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr><th>Nombre</th><th>Descripción</th><th>Precio</th><th>Estado</th><th class="text-end">Acciones</th></tr>
                        </thead>
                        <tbody>
                            @forelse($services as $service)
                            <tr>
                                <td style="font-weight:600;">{{ $service->name }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($service->description, 50) }}</td>
                                <td style="font-weight:600;color:var(--accent);">${{ number_format($service->price, 2) }}</td>
                                <td>
                                    @if($service->status === 'activo')
                                        <span class="badge-status badge-activa">Activo</span>
                                    @else
                                        <span class="badge-status badge-cancelada">Inactivo</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-ghost" style="color:var(--info);" data-bs-toggle="modal" data-bs-target="#editModal{{ $service->id }}" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form action="{{ route('panel.services.delete', $service->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este servicio?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-ghost" style="color:var(--danger);" title="Eliminar"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>

                            <div class="modal fade" id="editModal{{ $service->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('panel.services.update', $service->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <div class="modal-header">
                                                <h6 class="modal-title" style="font-weight:600;">Editar Servicio</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Nombre</label>
                                                    <input type="text" name="name" class="form-control" value="{{ $service->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Descripción</label>
                                                    <textarea name="description" class="form-control" rows="2">{{ $service->description }}</textarea>
                                                </div>
                                                <div class="row g-3">
                                                    <div class="col-6">
                                                        <label class="form-label">Precio</label>
                                                        <input type="number" name="price" class="form-control" step="0.01" min="0" value="{{ $service->price }}" required>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label">Estado</label>
                                                        <select name="status" class="form-select">
                                                            <option value="activo" {{ $service->status === 'activo' ? 'selected' : '' }}>Activo</option>
                                                            <option value="inactivo" {{ $service->status === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">No hay servicios registrados</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
