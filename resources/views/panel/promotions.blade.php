@extends('layouts.app')
@section('title', 'Promociones')
@section('page-title', 'Promociones')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="section-header">
            <h5><i class="bi bi-megaphone"></i> Gestionar Promociones</h5>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <span style="font-size:.85rem;color:var(--text-muted);">{{ $promotions->count() }} promociones</span>
            <a href="{{ route('panel.promotions.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i>Nueva Promoción
            </a>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr><th>Título</th><th>Descripción</th><th>Fechas</th><th>Estado</th><th class="text-end">Acciones</th></tr>
                        </thead>
                        <tbody>
                            @forelse($promotions as $promo)
                            <tr>
                                <td style="font-weight:600;">{{ $promo->title }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($promo->description, 50) }}</td>
                                <td>
                                    <small style="color:var(--text-muted);">
                                        {{ $promo->start_date ? $promo->start_date->format('d/m/Y') : '—' }}
                                        → {{ $promo->end_date ? $promo->end_date->format('d/m/Y') : '—' }}
                                    </small>
                                </td>
                                <td>
                                    @if($promo->status === 'activo')
                                        <span class="badge-status badge-activa">Activo</span>
                                    @else
                                        <span class="badge-status badge-cancelada">Inactivo</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('panel.promotions.edit', $promo->id) }}" class="btn btn-sm btn-ghost" style="color:var(--info);" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('panel.promotions.delete', $promo->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar esta promoción?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-ghost" style="color:var(--danger);" title="Eliminar"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">No hay promociones</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('panel.index') }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-arrow-left me-1"></i>Volver al panel</a>
        </div>
    </div>
</div>
@endsection
