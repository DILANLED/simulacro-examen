@extends('layouts.app')
@section('content')

<div class="container">
  <h2 class="mb-3">Roles</h2>

  @if(session('ok'))
    <div class="alert alert-success">{{ session('ok') }}</div>
  @endif

  <div class="d-flex gap-2 mb-3">
    <a href="{{ route('roles.create') }}" class="btn btn-primary">+ Nuevo</a>

    <form method="GET" action="{{ route('roles.index') }}" class="d-flex gap-2">
      <input name="q" value="{{ $q }}" class="form-control" placeholder="Buscar..." />
      <button class="btn btn-outline-secondary">Buscar</button>
    </form>

    <form method="POST" action="{{ route('roles.reportePDF') }}" class="ms-auto">
      @csrf
      <button class="btn btn-outline-dark">Reporte PDF</button>
    </form>
  </div>

  <table class="table table-striped align-middle">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Estado</th>
        <th style="width:240px">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($roles as $r)
        <tr>
          <td>{{ $r->id_rol }}</td>
          <td>{{ $r->nombre_rol }}</td>
          <td>
            <span class="badge {{ $r->estado_rol == 1 ? 'bg-success' : 'bg-secondary' }}">
              {{ $r->estado_rol == 1 ? 'Activo' : 'Inactivo' }}
            </span>
          </td>
          <td class="d-flex gap-2">
            <a href="{{ route('roles.edit', $r->id_rol) }}" class="btn btn-sm btn-warning">Editar</a>

            <form method="POST" action="{{ route('roles.cambiarEstado', $r->id_rol) }}">
              @csrf
              <button class="btn btn-sm btn-info" type="submit">Cambiar estado</button>
            </form>

            <form method="POST" action="{{ route('roles.destroy', $r->id_rol) }}"
                  onsubmit="return confirm('¿Eliminar rol?');">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-danger">Eliminar</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="4" class="text-center text-muted">No hay registros</td></tr>
      @endforelse
    </tbody>
  </table>

  {{ $roles->links() }}
</div>

@endsection
