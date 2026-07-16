@extends('layouts.app')
@section('title', 'Banner Principal')
@section('page-title', 'Banner Principal')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="bi bi-image text-accent me-2"></i>Editar Banner Principal</h6>
                <a href="{{ route('panel.index') }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-arrow-left me-1"></i>Volver</a>
            </div>
            <div class="card-body">
                <form action="{{ route('panel.hero.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Título Principal</label>
                        <input type="text" name="hero_title" class="form-control" value="{{ old('hero_title', $settings['hero_title'] ?? '') }}" placeholder="Ej: Bienvenido a">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subtítulo</label>
                        <input type="text" name="hero_subtitle" class="form-control" value="{{ old('hero_subtitle', $settings['hero_subtitle'] ?? '') }}" placeholder="Ej: Experiencia y lujo en cada detalle">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="hero_description" class="form-control" rows="3" placeholder="Descripción breve del hotel...">{{ old('hero_description', $settings['hero_description'] ?? '') }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Imagen de Fondo</label>
                        @if(!empty($settings['hero_image']))
                            <div class="mb-2 rounded overflow-hidden" style="max-height:200px;">
                                <img src="{{ asset('storage/' . $settings['hero_image']) }}" class="w-100" style="object-fit:cover;height:200px;" onerror="this.parentElement.style.display='none'">
                            </div>
                        @endif
                        <input type="file" name="hero_image" class="form-control" accept="image/*">
                        <small class="text-muted">Formatos: JPG, PNG, WebP. Máximo 5MB.</small>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
