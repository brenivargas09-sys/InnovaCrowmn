@extends('layouts.app')
@section('title', 'Nuevo Servicio')
@section('page-title', 'Crear Servicio')

@section('content')
<div class="row justify-content-center"><div class="col-lg-8"><div class="card border-0 shadow-sm"><div class="card-body">
    @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
    <form method="POST" action="{{ route('services.store') }}">
        @csrf
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Nombre</label><input type="text" name="name" class="form-control" value="{{ old('name') }}" required></div>
            <div class="col-md-3"><label class="form-label">Precio ($)</label><input type="number" name="price" class="form-control" step="0.01" min="0" value="{{ old('price') }}" required></div>
            <div class="col-md-3"><label class="form-label">Estado</label>
                <select name="status" class="form-select"><option value="activo">Activo</option><option value="inactivo">Inactivo</option></select>
            </div>
            <div class="col-12"><label class="form-label">Descripción</label><textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea></div>
        </div>
        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Guardar</button>
            <a href="{{ route('services.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div></div></div></div>
@endsection
