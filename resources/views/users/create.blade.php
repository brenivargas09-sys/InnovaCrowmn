@extends('layouts.app')
@section('title', 'Nuevo Usuario')
@section('page-title', 'Crear Usuario')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><h6 class="mb-0">Nuevo Usuario</h6></div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                @endif
                <form method="POST" action="{{ route('panel.users.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Usuario</label><input type="text" name="username" class="form-control" value="{{ old('username') }}" required></div>
                        <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email') }}" required></div>
                        <div class="col-md-6"><label class="form-label">Contraseña</label><input type="password" name="password" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label">Confirmar</label><input type="password" name="password_confirmation" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label">Rol</label>
                            <select name="role" class="form-select" required>
                                <option value="admin">Admin</option>
                                <option value="recepcionista">Recepcionista</option>
                                <option value="cliente" selected>Cliente</option>
                            </select>
                        </div>
                        <div class="col-md-6"><label class="form-label">Estado</label>
                            <select name="status" class="form-select" required>
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Guardar</button>
                        <a href="{{ route('panel.users.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
