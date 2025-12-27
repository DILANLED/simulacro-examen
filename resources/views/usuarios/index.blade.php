@extends('layouts.app') {{-- o tu layout --}}
@section('content')

<div class="container">
  <h2 class="mb-3">Usuarios</h2>

  @if(session('ok'))
    <div class="alert alert-success">{{ session('ok') }}</div>
  @endif

  <div class="d-flex gap-2 mb-3">
    <a href="{{ route('usuarios.create') }}" class="btn btn-primary">+ Nuevo</a>

    <form method="GET" action="{{ route('usuarios.index') }}" class="d-flex gap-2">
      <input name="q" value="{{ $q }}" class="form-control" placeholder="Buscar..." />
      <button class="btn btn-outline-secondary">Buscar</button>
    </form>

    <form method="POST" action="{{ route('usuarios.reportePDF') }}" class="ms-auto">
      @csrf
      <button class="btn btn-outline-dark">Reporte PDF</button>
    </form>
  </div>

  <table class="table table-striped align-middle">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Login</th>
        <th>Estado</th>
        <th style="width:240px">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($usuarios as $u)
        <tr>
          <td>{{ $u->id_usuario }}</td>
          <td>{{ $u->nombre_usuario }}</td>
          <td>{{ $u->nombre_login_usuario }}</td>
          <td>
            <span class="badge {{ $u->estado_usuario == 1 ? 'bg-success' : 'bg-secondary' }}">
              {{ $u->estado_usuario == 1 ? 'Activo' : 'Inactivo' }}
            </span>
          </td>
          <td class="d-flex gap-2">
            <a href="{{ route('usuarios.edit', $u->id_usuario) }}" class="btn btn-sm btn-warning">Editar</a>

            <form method="POST" action="{{ route('usuarios.cambiarEstado', $u->id_usuario) }}">
              @csrf
              <button class="btn btn-sm btn-info" type="submit">
                Cambiar estado
              </button>
            </form>

            <form method="POST" action="{{ route('usuarios.destroy', $u->id_usuario) }}"
                  onsubmit="return confirm('¿Eliminar usuario?');">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-danger">Eliminar</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="5" class="text-center text-muted">No hay registros</td></tr>
      @endforelse
    </tbody>
  </table>

  {{ $usuarios->links() }}
</div>

@endsection
