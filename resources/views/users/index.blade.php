@extends('layouts.app')
@section('title', 'Usuarios')
@section('page-title', 'Gestión de Usuarios')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Usuarios del Sistema</h6>
        <a href="{{ route('panel.users.create') }}" class="btn btn-sm btn-primary"><i class="bi bi-plus-circle me-1"></i>Nuevo</a>
    </div>
    <div class="card-body">
        <form class="row g-2 mb-3" method="GET">
            <div class="col-md-4"><input type="text" name="search" class="form-control form-control-sm" placeholder="Buscar..." value="{{ request('search') }}"></div>
            <div class="col-md-3">
                <select name="role" class="form-select form-select-sm">
                    <option value="">Todos los roles</option>
                    <option value="admin" {{ request('role')=='admin'?'selected':'' }}>Admin</option>
                    <option value="recepcionista" {{ request('role')=='recepcionista'?'selected':'' }}>Recepcionista</option>
                    <option value="cliente" {{ request('role')=='cliente'?'selected':'' }}>Cliente</option>
                </select>
            </div>
            <div class="col-md-2"><button class="btn btn-sm btn-primary w-100">Buscar</button></div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light"><tr><th>ID</th><th>Usuario</th><th>Email</th><th>Rol</th><th>Estado</th><th>Acciones</th></tr></thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td><strong>{{ $user->username }}</strong></td>
                        <td>{{ $user->email }}</td>
                        <td><span class="badge bg-{{ $user->role=='admin'?'danger':($user->role=='recepcionista'?'primary':'secondary') }}">{{ ucfirst($user->role) }}</span></td>
                        <td><span class="badge bg-{{ $user->status=='activo'?'success':'warning' }}">{{ ucfirst($user->status) }}</span></td>
                        <td>
                            <a href="{{ route('panel.users.edit', $user) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('panel.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este usuario?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted">No se encontraron usuarios</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $users->withQueryString()->links() }}
    </div>
</div>
@endsection
