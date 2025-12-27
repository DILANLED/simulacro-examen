@extends('layouts.app')
@section('content')

<div class="container">
  <h2 class="mb-3">Editar Rol #{{ $rol->id_rol }}</h2>

  <form method="POST" action="{{ route('roles.update', $rol->id_rol) }}">
    @csrf
    @method('PUT')
    @include('roles.form', ['rol' => $rol, 'modo' => 'edit'])
    <button class="btn btn-warning">Actualizar</button>
    <a href="{{ route('roles.index') }}" class="btn btn-secondary">Volver</a>
  </form>
</div>

@endsection
