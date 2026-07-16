@extends('layouts.app')
@section('title', 'Editar Tipo')
@section('page-title', 'Editar Tipo: ' . $roomType->name)

@section('content')
<div class="row justify-content-center"><div class="col-lg-8"><div class="card border-0 shadow-sm"><div class="card-body">
    @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
    <form method="POST" action="{{ route('room-types.update', $roomType) }}">
        @csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Nombre</label><input type="text" name="name" class="form-control" value="{{ old('name', $roomType->name) }}" required></div>
            <div class="col-md-3"><label class="form-label">Capacidad</label><input type="number" name="capacity" class="form-control" value="{{ old('capacity', $roomType->capacity) }}" min="1" required></div>
            <div class="col-md-3"><label class="form-label">Precio/Noche ($)</label><input type="number" name="price_per_night" class="form-control" value="{{ old('price_per_night', $roomType->price_per_night) }}" step="0.01" min="0" required></div>
            <div class="col-md-6"><label class="form-label">Imagen</label><input type="text" name="image" class="form-control" value="{{ old('image', $roomType->image) }}"></div>
            <div class="col-12"><label class="form-label">Descripción</label><textarea name="description" class="form-control" rows="3">{{ old('description', $roomType->description) }}</textarea></div>
        </div>
        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Actualizar</button>
            <a href="{{ route('room-types.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div></div></div></div>
@endsection
