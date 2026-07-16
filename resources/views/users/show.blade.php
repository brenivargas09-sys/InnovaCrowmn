@extends('layouts.app')
@section('title', 'Detalle de Usuario')
@section('page-title', 'Usuario: ' . $user->username)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><h6 class="mb-0">Detalle de Usuario</h6></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label text-muted mb-0">ID</label>
                        <div class="fw-semibold">{{ $user->id }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted mb-0">Usuario</label>
                        <div class="fw-semibold">{{ $user->username }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted mb-0">Email</label>
                        <div class="fw-semibold">{{ $user->email }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted mb-0">Rol</label>
                        <div><span class="badge bg-{{ $user->role=='admin'?'danger':($user->role=='recepcionista'?'primary':'secondary') }}">{{ ucfirst($user->role) }}</span></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted mb-0">Estado</label>
                        <div><span class="badge bg-{{ $user->status=='activo'?'success':'warning' }}">{{ ucfirst($user->status) }}</span></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted mb-0">Creado</label>
                        <div class="fw-semibold">{{ $user->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted mb-0">Última actualización</label>
                        <div class="fw-semibold">{{ $user->updated_at->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
                <div class="mt-4 d-flex gap-2">
                    <a href="{{ route('panel.users.edit', $user) }}" class="btn btn-primary"><i class="bi bi-pencil me-1"></i>Editar</a>
                    <a href="{{ route('panel.users.index') }}" class="btn btn-outline-secondary">Volver</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
