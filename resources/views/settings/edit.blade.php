@extends('layouts.app')
@section('title', 'Editar - ' . $sectionData['label'])
@section('page-title', 'Editar: ' . $sectionData['label'])

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $sectionData['label'] }}</h5>
                <a href="{{ route('settings.index') }}" class="btn btn-sm btn-outline-secondary">Volver</a>
            </div>
            <div class="card-body">
                <form action="{{ route('settings.update', $section) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @foreach($sectionData['fields'] as $key => $field)
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ $field['label'] }}</label>
                        @if($field['type'] === 'textarea')
                            <textarea name="{{ $key }}" class="form-control @error($key) is-invalid @enderror" rows="4">{{ old($key, $settings[$key] ?? '') }}</textarea>
                        @else
                            <input type="text" name="{{ $key }}" class="form-control @error($key) is-invalid @enderror" value="{{ old($key, $settings[$key] ?? '') }}">
                        @endif
                        @error($key)
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if(str_contains($key, 'image') || str_contains($key, 'gallery'))
                            <small class="text-muted">Ingresa la ruta de la imagen (ej: images/hero.jpg) o una URL completa.</small>
                        @endif
                    </div>
                    @endforeach

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        <a href="{{ route('settings.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white"><h6 class="mb-0">Vista Previa</h6></div>
            <div class="card-body text-center">
                <a href="/" target="_blank" class="btn btn-accent"><i class="bi bi-eye me-1"></i>Ver Página Pública</a>
            </div>
        </div>
    </div>
</div>
@endsection
