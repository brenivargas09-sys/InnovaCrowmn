@extends('layouts.app')
@section('title', 'Editar Servicio')
@section('page-title', 'Editar Servicio: ' . $service->name)

@section('content')
<div class="row justify-content-center"><div class="col-lg-8"><div class="card border-0 shadow-sm"><div class="card-body">
    @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
    <form method="POST" action="{{ route('services.update', $service) }}">
        @csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Nombre</label><input type="text" name="name" class="form-control" value="{{ old('name', $service->name) }}" required></div>
            <div class="col-md-3"><label class="form-label">Precio ($)</label><input type="number" name="price" class="form-control" step="0.01" min="0" value="{{ old('price', $service->price) }}" required></div>
            <div class="col-md-3"><label class="form-label">Estado</label>
                <select name="status" class="form-select">
                    <option value="activo" {{ old('status', $service->status)==='activo'?'selected':'' }}>Activo</option>
                    <option value="inactivo" {{ old('status', $service->status)==='inactivo'?'selected':'' }}>Inactivo</option>
                </select>
            </div>
            <div class="col-12"><label class="form-label">Descripción</label><textarea name="description" class="form-control" rows="3">{{ old('description', $service->description) }}</textarea></div>
        </div>
        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Actualizar</button>
            <a href="{{ route('services.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div></div></div></div>
@endsection
