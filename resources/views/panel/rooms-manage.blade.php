@extends('layouts.app')
@section('title', 'Tipos de Habitación')
@section('page-title', 'Tipos de Habitación')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="bi bi-plus-circle text-accent me-2"></i>Agregar Tipo de Habitación</h6>
                <a href="{{ route('panel.index') }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-arrow-left me-1"></i>Volver</a>
            </div>
            <div class="card-body">
                <form action="{{ route('panel.rooms.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="name" class="form-control" required placeholder="Ej: Suite Presidencial">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Descripción</label>
                            <input type="text" name="description" class="form-control" placeholder="Descripción breve">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Precio /noche</label>
                            <input type="number" name="price_per_night" class="form-control" step="0.01" min="0" required>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">Capacidad</label>
                            <input type="number" name="capacity" class="form-control" min="1" value="2">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Imagen</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary w-100"><i class="bi bi-plus-lg"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row g-3">
            @forelse($roomTypes as $rt)
            <div class="col-lg-4 col-md-6">
                <div class="card h-100" style="border:1px solid var(--border-light);">
                    <div style="height:160px;overflow:hidden;border-radius:12px 12px 0 0;">
                        @if(!empty($rt->image))
                            <img src="{{ asset('storage/' . $rt->image) }}" class="w-100 h-100" style="object-fit:cover;" alt="{{ $rt->name }}">
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100" style="background:linear-gradient(135deg,var(--primary),var(--dark));">
                                <i class="bi bi-building fs-2" style="color:var(--accent);opacity:.4;"></i>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 style="font-weight:700;margin:0;">{{ $rt->name }}</h6>
                            <span style="font-family:'Playfair Display',serif;font-weight:700;color:var(--accent);font-size:1rem;">${{ number_format($rt->price_per_night, 0) }}<small style="font-family:'Inter',sans-serif;font-size:.7rem;color:var(--text-muted);">/noche</small></span>
                        </div>
                        <p style="font-size:.82rem;color:var(--text-muted);margin-bottom:.5rem;">{{ \Illuminate\Support\Str::limit($rt->description, 80) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small style="color:var(--text-muted);"><i class="bi bi-people me-1"></i>{{ $rt->capacity }} personas</small>
                            <div class="d-flex gap-1">
                                <button class="btn btn-sm btn-ghost" style="color:var(--info);" data-bs-toggle="modal" data-bs-target="#editRT{{ $rt->id }}" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('panel.rooms.delete', $rt->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este tipo de habitación?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-ghost" style="color:var(--danger);" title="Eliminar"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="editRT{{ $rt->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('panel.rooms.update', $rt->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf @method('PUT')
                                <div class="modal-header">
                                    <h6 class="modal-title" style="font-weight:600;">Editar: {{ $rt->name }}</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nombre</label>
                                        <input type="text" name="name" class="form-control" value="{{ $rt->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Descripción</label>
                                        <textarea name="description" class="form-control" rows="2">{{ $rt->description }}</textarea>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <label class="form-label">Precio /noche</label>
                                            <input type="number" name="price_per_night" class="form-control" step="0.01" min="0" value="{{ $rt->price_per_night }}" required>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Capacidad</label>
                                            <input type="number" name="capacity" class="form-control" min="1" value="{{ $rt->capacity }}">
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <label class="form-label">Nueva Imagen (opcional)</label>
                                        <input type="file" name="image" class="form-control" accept="image/*">
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
            </div>
            @empty
            <div class="col-12">
                <div class="empty-state py-4">
                    <i class="bi bi-building d-block"></i>
                    <h6>Sin tipos de habitación</h6>
                    <p>Agrega el primer tipo de habitación usando el formulario de arriba.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
