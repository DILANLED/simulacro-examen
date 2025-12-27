@extends('layouts.app')
@section('content')

<div class="container">
  <h2 class="mb-3">Editar Carrera #{{ $carrera->id_carrera }}</h2>

  <form method="POST" action="{{ route('carreras.update', $carrera->id_carrera) }}">
    @csrf
    @method('PUT')

    @include('carreras.form', [
      'carrera' => $carrera,
      'modo' => 'edit'
    ])

    <button class="btn btn-warning">Actualizar</button>
    <a href="{{ route('carreras.index') }}" class="btn btn-secondary">Volver</a>
  </form>
</div>

@endsection
