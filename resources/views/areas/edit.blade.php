@extends('layouts.app')
@section('content')

<div class="container">
  <h2 class="mb-3">Editar Área #{{ $area->id_area }}</h2>

  <form method="POST" action="{{ route('areas.update', $area->id_area) }}">
    @csrf
    @method('PUT')
    @include('areas.form', ['area' => $area])
    <button class="btn btn-warning">Actualizar</button>
    <a href="{{ route('areas.index') }}" class="btn btn-secondary">Volver</a>
  </form>
</div>

@endsection
