@extends('layouts.app')
@section('content')

<div class="container">
  <h2 class="mb-3">Áreas</h2>

  @if(session('ok'))
    <div class="alert alert-success">{{ session('ok') }}</div>
  @endif

  <div class="d-flex gap-2 mb-3">
    <a href="{{ route('areas.create') }}" class="btn btn-primary">+ Nueva</a>

    <form method="GET" action="{{ route('areas.index') }}" class="d-flex gap-2">
      <input name="q" value="{{ $q }}" class="form-control" placeholder="Buscar..." />
      <button class="btn btn-outline-secondary">Buscar</button>
    </form>

    <form method="POST" action="{{ route('areas.reportePDF') }}" class="ms-auto">
      @csrf
      <button class="btn btn-outline-dark">Reporte PDF</button>
    </form>
  </div>

  <table class="table table-striped align-middle">
    <thead>
      <tr>
        <th>ID</th>
        <th>Área</th>
        <th>Carrera</th>
        <th># Preguntas</th>
        <th>Estado</th>
        <th style="width:240px">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($areas as $a)
        <tr>
          <td>{{ $a->id_area }}</td>
          <td>{{ $a->nombre_area }}</td>
          <td>{{ $a->carrera->nombre_carrera ?? '-' }}</td>
          <td>{{ $a->n_preguntas }}</td>
          <td>
            <span class="badge {{ $a->estado_area == 1 ? 'bg-success' : 'bg-secondary' }}">
              {{ $a->estado_area == 1 ? 'Activo' : 'Inactivo' }}
            </span>
          </td>
          <td class="d-flex gap-2">
            <a href="{{ route('areas.edit', $a->id_area) }}" class="btn btn-sm btn-warning">Editar</a>

            <form method="POST" action="{{ route('areas.cambiarEstado', $a->id_area) }}">
              @csrf
              <button class="btn btn-sm btn-info">Cambiar estado</button>
            </form>

            <form method="POST" action="{{ route('areas.destroy', $a->id_area) }}"
                  onsubmit="return confirm('¿Eliminar área?');">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-danger">Eliminar</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="6" class="text-center text-muted">No hay registros</td></tr>
      @endforelse
    </tbody>
  </table>

  {{ $areas->links() }}
</div>

@endsection
