@extends('layouts.app')
@section('title', 'Nuevo Cliente')
@section('page-title', 'Registrar Cliente')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><h6 class="mb-0">Nuevo Cliente</h6></div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                @endif
                <form method="POST" action="{{ route('clients.store') }}">
                    @csrf
                    <h6 class="text-muted border-bottom pb-2 mb-3">Datos Personales</h6>
                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label">Nombre(s)</label><input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required></div>
                        <div class="col-md-4"><label class="form-label">Apellido(s)</label><input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" required></div>
                        <div class="col-md-4"><label class="form-label">Teléfono</label><input type="text" name="phone" class="form-control" value="{{ old('phone') }}"></div>
                        <div class="col-md-4"><label class="form-label">Dirección</label><input type="text" name="address" class="form-control" value="{{ old('address') }}"></div>
                        <div class="col-md-4"><label class="form-label">Ciudad</label><input type="text" name="city" class="form-control" value="{{ old('city') }}"></div>
                        <div class="col-md-4"><label class="form-label">Nacionalidad</label><input type="text" name="nationality" class="form-control" value="{{ old('nationality', 'Mexicana') }}"></div>
                        <div class="col-md-4"><label class="form-label">Tipo de ID</label>
                            <select name="id_type" class="form-select"><option value="INE">INE</option><option value="Pasaporte">Pasaporte</option><option value="Licencia">Licencia</option><option value="Otro">Otro</option></select>
                        </div>
                        <div class="col-md-4"><label class="form-label">Número de ID</label><input type="text" name="id_number" class="form-control" value="{{ old('id_number') }}" required></div>
                    </div>
                    <h6 class="text-muted border-bottom pb-2 mb-3 mt-4">Cuenta de Acceso</h6>
                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label">Usuario</label><input type="text" name="username" class="form-control" value="{{ old('username') }}" required></div>
                        <div class="col-md-4"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email') }}" required></div>
                        <div class="col-md-4"><label class="form-label">Contraseña</label><input type="password" name="password" class="form-control" required></div>
                        <div class="col-md-4"><label class="form-label">Confirmar Contraseña</label><input type="password" name="password_confirmation" class="form-control" required></div>
                    </div>
                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Guardar</button>
                        <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
