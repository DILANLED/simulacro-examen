@extends('layouts.app')
@section('content')

<div class="container">
  <h2 class="mb-3">Crear Usuario</h2>

  <form method="POST" action="{{ route('usuarios.store') }}">
    @csrf
    @include('usuarios.form', ['usuario' => null, 'modo' => 'create'])
    <button class="btn btn-primary">Guardar</button>
    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Volver</a>
  </form>
</div>

@endsection
