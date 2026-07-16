@extends('layouts.app')
@section('title', 'Editar Cliente')
@section('page-title', 'Editar Cliente: ' . $client->full_name)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><h6 class="mb-0">Editar Cliente</h6></div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                @endif
                <form method="POST" action="{{ route('clients.update', $client) }}">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label">Nombre(s)</label><input type="text" name="first_name" class="form-control" value="{{ old('first_name', $client->first_name) }}" required></div>
                        <div class="col-md-4"><label class="form-label">Apellido(s)</label><input type="text" name="last_name" class="form-control" value="{{ old('last_name', $client->last_name) }}" required></div>
                        <div class="col-md-4"><label class="form-label">Teléfono</label><input type="text" name="phone" class="form-control" value="{{ old('phone', $client->phone) }}"></div>
                        <div class="col-md-4"><label class="form-label">Dirección</label><input type="text" name="address" class="form-control" value="{{ old('address', $client->address) }}"></div>
                        <div class="col-md-4"><label class="form-label">Ciudad</label><input type="text" name="city" class="form-control" value="{{ old('city', $client->city) }}"></div>
                        <div class="col-md-4"><label class="form-label">Nacionalidad</label><input type="text" name="nationality" class="form-control" value="{{ old('nationality', $client->nationality) }}"></div>
                        <div class="col-md-4"><label class="form-label">Tipo de ID</label>
                            <select name="id_type" class="form-select">
                                @foreach(['INE','Pasaporte','Licencia','Otro'] as $t)
                                <option {{ old('id_type', $client->id_type)===$t?'selected':'' }}>{{ $t }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4"><label class="form-label">Número de ID</label><input type="text" name="id_number" class="form-control" value="{{ old('id_number', $client->id_number) }}" required></div>
                    </div>
                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Actualizar</button>
                        <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
