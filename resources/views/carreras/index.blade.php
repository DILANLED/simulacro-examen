@extends('layouts.app')
@section('content')

<div class="container">
  <h2 class="mb-3">Carreras</h2>

  @if(session('ok'))
    <div class="alert alert-success">{{ session('ok') }}</div>
  @endif

  <div class="d-flex gap-2 mb-3">
    <a href="{{ route('carreras.create') }}" class="btn btn-primary">+ Nueva</a>

    <form method="GET" action="{{ route('carreras.index') }}" class="d-flex gap-2">
      <input name="q" value="{{ $q }}" class="form-control" placeholder="Buscar..." />
      <button class="btn btn-outline-secondary">Buscar</button>
    </form>

    <form method="POST" action="{{ route('carreras.reportePDF') }}" class="ms-auto">
      @csrf
      <button class="btn btn-outline-dark">Reporte PDF</button>
    </form>
  </div>

  <table class="table table-striped align-middle">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre de la Carrera</th>
        <th>Gestión</th>
        <th>Estado</th>
        <th style="width:240px">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($carreras as $c)
        <tr>
          <td>{{ $c->id_carrera }}</td>
          <td>{{ $c->nombre_carrera }}</td>
          <td>{{ $c->gestion_carrera }}</td>
          <td>
            <span class="badge {{ $c->estado_carrera == 1 ? 'bg-success' : 'bg-secondary' }}">
              {{ $c->estado_carrera == 1 ? 'Activo' : 'Inactivo' }}
            </span>
          </td>
          <td class="d-flex gap-2">
            <a href="{{ route('carreras.edit', $c->id_carrera) }}" class="btn btn-sm btn-warning">Editar</a>

            <form method="POST" action="{{ route('carreras.cambiarEstado', $c->id_carrera) }}">
              @csrf
              <button class="btn btn-sm btn-info" type="submit">Cambiar estado</button>
            </form>

            <form method="POST" action="{{ route('carreras.destroy', $c->id_carrera) }}"
                  onsubmit="return confirm('¿Eliminar carrera?');">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-danger">Eliminar</button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="5" class="text-center text-muted">No hay registros</td>
        </tr>
      @endforelse
    </tbody>
  </table>

  {{ $carreras->links() }}
</div>

@endsection
