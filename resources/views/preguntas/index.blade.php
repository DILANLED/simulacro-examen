@extends('layouts.app')
@section('content')

<div class="container">
  <h2 class="mb-3">Preguntas</h2>

  @if(session('ok'))
    <div class="alert alert-success">{{ session('ok') }}</div>
  @endif

  <div class="d-flex gap-2 mb-3">
    <a href="{{ route('preguntas.create') }}" class="btn btn-primary">+ Nueva Pregunta</a>

    <form method="GET" action="{{ route('preguntas.index') }}" class="d-flex gap-2">
      <input name="q" value="{{ $q }}" class="form-control" placeholder="Buscar pregunta..." />
      <button class="btn btn-outline-secondary">Buscar</button>
    </form>

    <form method="POST" action="{{ route('preguntas.reportePDF') }}" class="ms-auto">
      @csrf
      <button class="btn btn-outline-dark">Reporte PDF</button>
    </form>
  </div>

  <table class="table table-striped align-middle">
    <thead>
      <tr>
        <th>ID</th>
        <th>Pregunta</th>
        <th>Área</th>
        <th>Estado</th>
        <th style="width:320px">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($preguntas as $p)
        <tr>
          <td>{{ $p->id_pregunta }}</td>
          <td>{{ $p->texto_pregunta }}</td>
          <td>{{ $p->area->nombre_area ?? 'Sin área' }}</td>
          <td>
            <span class="badge {{ $p->estado_pregunta == 1 ? 'bg-success' : 'bg-secondary' }}">
              {{ $p->estado_pregunta == 1 ? 'Activo' : 'Inactivo' }}
            </span>
          </td>
          <td class="d-flex gap-2">
            <a href="{{ route('preguntas.edit', $p->id_pregunta) }}" class="btn btn-sm btn-warning">Editar</a>

            <form method="POST" action="{{ route('preguntas.cambiarEstado', $p->id_pregunta) }}">
              @csrf
              <button class="btn btn-sm btn-info" type="submit">Cambiar estado</button>
            </form>

            <form method="POST" action="{{ route('preguntas.destroy', $p->id_pregunta) }}"
                  onsubmit="return confirm('¿Eliminar pregunta?');">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-danger">Eliminar</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="5" class="text-center text-muted">No hay preguntas registradas</td></tr>
      @endforelse
    </tbody>
  </table>

  {{ $preguntas->links() }}
</div>

@endsection
