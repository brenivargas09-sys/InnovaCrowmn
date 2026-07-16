@extends('layouts.app')
@section('title', 'Galería de Imágenes')
@section('page-title', 'Galería de Imágenes')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="bi bi-images text-accent me-2"></i>Gestionar Galería</h6>
                <a href="{{ route('panel.index') }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-arrow-left me-1"></i>Volver</a>
            </div>
            <div class="card-body">
                <form action="{{ route('panel.gallery.upload') }}" method="POST" enctype="multipart/form-data" class="mb-4">
                    @csrf
                    <div class="row g-3 align-items-end">
                        <div class="col-md-8">
                            <label class="form-label">Seleccionar Imagen</label>
                            <input type="file" name="gallery_image" class="form-control" accept="image/*" required>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100"><i class="bi bi-upload me-1"></i>Subir Imagen</button>
                        </div>
                    </div>
                </form>

                @if(isset($images) && count($images))
                    <div class="row g-3">
                        @foreach($images as $image)
                            <div class="col-lg-3 col-md-4 col-6">
                                <div class="card overflow-hidden" style="border:1px solid var(--border-light);">
                                    <div style="height:160px;overflow:hidden;">
                                        <img src="{{ asset('storage/' . ($image->value ?? '')) }}" class="w-100 h-100" style="object-fit:cover;" alt="Galería" onerror="this.parentElement.innerHTML='<div class=\'d-flex align-items-center justify-content-center h-100\' style=\'background:var(--surface-alt);color:var(--text-muted);\'><i class=\'bi bi-image fs-3\'></i></div>'">
                                    </div>
                                    <div class="card-body p-2 d-flex justify-content-between align-items-center">
                                        <small class="text-muted text-truncate me-2">{{ basename($image->value ?? '') }}</small>
                                        <form action="{{ route('panel.gallery.delete', $image->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar esta imagen?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-ghost" style="color:var(--danger);" title="Eliminar"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state py-4">
                        <i class="bi bi-images d-block"></i>
                        <h6>Sin imágenes</h6>
                        <p>Sube imágenes para que aparezcan en la galería del sitio web.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
