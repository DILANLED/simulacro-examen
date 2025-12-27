@extends('layouts.app')
@section('content')

<div class="container">
  <h2 class="mb-3">Crear Rol</h2>

  <form method="POST" action="{{ route('roles.store') }}">
    @csrf
    @include('roles.form', ['rol' => null, 'modo' => 'create'])
    <button class="btn btn-primary">Guardar</button>
    <a href="{{ route('roles.index') }}" class="btn btn-secondary">Volver</a>
  </form>
</div>

@endsection
