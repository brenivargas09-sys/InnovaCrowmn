@extends('layouts.app')
@section('title', $promotion->exists ? 'Editar Promoción' : 'Nueva Promoción')
@section('page-title', $promotion->exists ? 'Editar Promoción' : 'Nueva Promoción')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="bi bi-megaphone text-accent me-2"></i>{{ $promotion->exists ? 'Editar' : 'Crear' }} Promoción</h6>
                <a href="{{ route('panel.promotions') }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-arrow-left me-1"></i>Volver</a>
            </div>
            <div class="card-body">
                <form action="{{ $promotion->exists ? route('panel.promotions.update', $promotion->id) : route('panel.promotions.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if($promotion->exists) @method('PUT') @endif

                    <div class="mb-3">
                        <label class="form-label">Título</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $promotion->title ?? '') }}" required placeholder="Título de la promoción">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Describe la promoción...">{{ old('description', $promotion->description ?? '') }}</textarea>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">URL de Imagen (opcional)</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            @if(!empty($promotion->image))
                                <div class="mt-2"><img src="{{ asset('storage/' . $promotion->image) }}" style="max-height:80px;border-radius:6px;" onerror="this.style.display='none'"></div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Enlace (opcional)</label>
                            <input type="url" name="link" class="form-control" value="{{ old('link', $promotion->link ?? '') }}" placeholder="https://...">
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Fecha Inicio</label>
                            <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $promotion->start_date?->format('Y-m-d') ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Fecha Fin</label>
                            <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $promotion->end_date?->format('Y-m-d') ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Estado</label>
                            <select name="status" class="form-select">
                                <option value="activo" {{ ($promotion->status ?? 'activo') === 'activo' ? 'selected' : '' }}>Activo</option>
                                <option value="inactivo" {{ ($promotion->status ?? '') === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Orden</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $promotion->sort_order ?? 0) }}" min="0" style="max-width:120px;">
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>{{ $promotion->exists ? 'Guardar Cambios' : 'Crear Promoción' }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
