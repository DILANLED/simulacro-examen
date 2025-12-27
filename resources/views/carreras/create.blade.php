@extends('layouts.app')
@section('content')

<div class="container">
  <h2 class="mb-3">Crear Carrera</h2>

  <form method="POST" action="{{ route('carreras.store') }}">
    @csrf

    @include('carreras.form', [
        'carrera' => null,
        'modo' => 'create'
    ])

    <button class="btn btn-primary">Guardar</button>
    <a href="{{ route('carreras.index') }}" class="btn btn-secondary">Volver</a>
  </form>
</div>

@endsection
