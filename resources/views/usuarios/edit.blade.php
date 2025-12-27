@extends('layouts.app')
@section('content')

<div class="container">
  <h2 class="mb-3">Editar Usuario #{{ $usuario->id_usuario }}</h2>

  <form method="POST" action="{{ route('usuarios.update', $usuario->id_usuario) }}">
    @csrf
    @method('PUT')
    @include('usuarios.form', ['usuario' => $usuario, 'modo' => 'edit'])
    <button class="btn btn-warning">Actualizar</button>
    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Volver</a>
  </form>
</div>

@endsection
