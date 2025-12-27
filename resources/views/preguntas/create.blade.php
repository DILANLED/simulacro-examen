@extends('layouts.app')
@section('content')

<div class="container">
    <h2 class="mb-3">Crear Pregunta</h2>

    <form method="POST" action="{{ route('preguntas.store') }}">
        @csrf

        {{-- Seleccionar área --}}
        <div class="mb-3">
            <label class="form-label">Área</label>
            <select name="id_area" class="form-select @error('id_area') is-invalid @enderror">
                <option value="">-- Seleccione área --</option>
                @foreach($areas as $area)
                    <option value="{{ $area->id_area }}" {{ old('id_area') == $area->id_area ? 'selected' : '' }}>
                        {{ $area->nombre_area }}
                    </option>
                @endforeach
            </select>
            @error('id_area') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Texto de la pregunta --}}
        <div class="mb-3">
            <label class="form-label">Pregunta</label>
            <input type="text" name="texto_pregunta" 
                   class="form-control @error('texto_pregunta') is-invalid @enderror"
                   value="{{ old('texto_pregunta') }}">
            @error('texto_pregunta') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Estado --}}
        <div class="mb-3">
            <label class="form-label">Estado</label>
            @php $estado = old('estado_pregunta', 1); @endphp
            <select name="estado_pregunta" class="form-select @error('estado_pregunta') is-invalid @enderror">
                <option value="1" {{ $estado == 1 ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ $estado == 0 ? 'selected' : '' }}>Inactivo</option>
            </select>
            @error('estado_pregunta') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Opciones dinámicas --}}
        <div class="mb-3">
            <label class="form-label">Opciones</label>
            <div id="opciones-container">
                <div class="opcion mb-2">
                    <input type="text" name="opciones[0][texto_opcion]" class="form-control mb-1" placeholder="Texto de opción">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="opciones[0][es_correcta]" value="1">
                        <label class="form-check-label">Correcta</label>
                    </div>
                    <select name="opciones[0][estado_opcion]" class="form-select mt-1">
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                    <hr>
                </div>
            </div>
            <button type="button" id="agregar-opcion" class="btn btn-sm btn-outline-primary mt-2">Agregar Opción</button>
        </div>

        <button class="btn btn-primary">Guardar</button>
        <a href="{{ route('preguntas.index') }}" class="btn btn-secondary">Volver</a>
    </form>
</div>

{{-- Script para agregar opciones dinámicamente --}}
<script>
let contador = 1;
document.getElementById('agregar-opcion').addEventListener('click', function() {
    const container = document.getElementById('opciones-container');
    const div = document.createElement('div');
    div.classList.add('opcion', 'mb-2');
    div.innerHTML = `
        <input type="text" name="opciones[${contador}][texto_opcion]" class="form-control mb-1" placeholder="Texto de opción">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="opciones[${contador}][es_correcta]" value="1">
            <label class="form-check-label">Correcta</label>
        </div>
        <select name="opciones[${contador}][estado_opcion]" class="form-select mt-1">
            <option value="1">Activo</option>
            <option value="0">Inactivo</option>
        </select>
        <hr>
    `;
    container.appendChild(div);
    contador++;
});
</script>

@endsection
