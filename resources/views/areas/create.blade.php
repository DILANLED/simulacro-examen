@extends('layouts.app')
@section('content')

<div class="container">
  <h2 class="mb-3">Crear Área</h2>

  <form method="POST" action="{{ route('areas.store') }}">
    @csrf
    @include('areas.form', ['area' => null])
    <button class="btn btn-primary">Guardar</button>
    <a href="{{ route('areas.index') }}" class="btn btn-secondary">Volver</a>
  </form>
</div>

@endsection
