@extends('layouts.app')
@section('title', 'Editar Usuario')
@section('page-title', 'Editar Usuario: ' . $user->username)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><h6 class="mb-0">Editar Usuario</h6></div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                @endif
                <form method="POST" action="{{ route('panel.users.update', $user) }}">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Usuario</label><input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" required></div>
                        <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required></div>
                        <div class="col-md-6"><label class="form-label">Nueva Contraseña <small class="text-muted">(dejar vacío para mantener)</small></label><input type="password" name="password" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">Confirmar</label><input type="password" name="password_confirmation" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">Rol</label>
                            <select name="role" class="form-select" required>
                                <option value="admin" {{ old('role', $user->role)=='admin'?'selected':'' }}>Admin</option>
                                <option value="recepcionista" {{ old('role', $user->role)=='recepcionista'?'selected':'' }}>Recepcionista</option>
                                <option value="cliente" {{ old('role', $user->role)=='cliente'?'selected':'' }}>Cliente</option>
                            </select>
                        </div>
                        <div class="col-md-6"><label class="form-label">Estado</label>
                            <select name="status" class="form-select" required>
                                <option value="activo" {{ old('status', $user->status)=='activo'?'selected':'' }}>Activo</option>
                                <option value="inactivo" {{ old('status', $user->status)=='inactivo'?'selected':'' }}>Inactivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Actualizar</button>
                        <a href="{{ route('panel.users.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
