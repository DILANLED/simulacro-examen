@extends('layouts.app')
@section('content')

<div class="container">
    <h2 class="mb-3">Editar Pregunta #{{ $pregunta->id_pregunta }}</h2>

    @if(session('ok'))
        <div class="alert alert-success">{{ session('ok') }}</div>
    @endif

    <form method="POST" action="{{ route('preguntas.update', $pregunta->id_pregunta) }}">
        @csrf
        @method('PUT')

        {{-- Selección de Área --}}
        <div class="mb-3">
            <label class="form-label">Área</label>
            <select class="form-select @error('id_area') is-invalid @enderror" name="id_area">
                <option value="">Selecciona un área</option>
                @foreach($areas as $area)
                    <option value="{{ $area->id_area }}" 
                        {{ old('id_area', $pregunta->id_area) == $area->id_area ? 'selected' : '' }}>
                        {{ $area->nombre_area }}
                    </option>
                @endforeach
            </select>
            @error('id_area') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Texto de la Pregunta --}}
        <div class="mb-3">
            <label class="form-label">Pregunta</label>
            <input type="text"
                   class="form-control @error('texto_pregunta') is-invalid @enderror"
                   name="texto_pregunta"
                   value="{{ old('texto_pregunta', $pregunta->texto_pregunta) }}">
            @error('texto_pregunta') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Estado de la pregunta --}}
        <div class="mb-3">
            <label class="form-label">Estado</label>
            @php $estado_pregunta = old('estado_pregunta', $pregunta->estado_pregunta); @endphp
            <select class="form-select @error('estado_pregunta') is-invalid @enderror" name="estado_pregunta">
                <option value="1" {{ $estado_pregunta == 1 ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ $estado_pregunta == 0 ? 'selected' : '' }}>Inactivo</option>
            </select>
            @error('estado_pregunta') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <hr>
        <h4>Opciones</h4>

        {{-- Opciones existentes --}}
        <div id="opciones_existentes">
            @foreach($pregunta->opciones as $opcion)
                <div class="mb-2 border p-2 rounded d-flex align-items-center gap-2">
                    <input type="hidden" name="opciones[{{ $loop->index }}][id_opcion]" value="{{ $opcion->id_opcion }}">

                    <input type="text"
                           class="form-control"
                           name="opciones[{{ $loop->index }}][texto_opcion]"
                           value="{{ old('opciones.'.$loop->index.'.texto_opcion', $opcion->texto_opcion) }}">

                    <div class="form-check">
                        <input class="form-check-input"
                               type="checkbox"
                               name="opciones[{{ $loop->index }}][es_correcta]"
                               value="1"
                               {{ old('opciones.'.$loop->index.'.es_correcta', $opcion->es_correcta) ? 'checked' : '' }}>
                        <label class="form-check-label">Correcta</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input"
                               type="checkbox"
                               name="opciones[{{ $loop->index }}][estado_opcion]"
                               value="1"
                               {{ old('opciones.'.$loop->index.'.estado_opcion', $opcion->estado_opcion) ? 'checked' : '' }}>
                        <label class="form-check-label">Activa</label>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Contenedor para nuevas opciones --}}
        <div id="opciones_nuevas"></div>

        <button type="button" class="btn btn-sm btn-success mb-3" id="agregar_opcion">+ Agregar Opción</button>

        <div class="mt-3">
            <button type="submit" class="btn btn-warning">Actualizar</button>
            <a href="{{ route('preguntas.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </form>
</div>

{{-- Script para agregar nuevas opciones dinámicamente --}}
<script>
    let contador = 0;
    document.getElementById('agregar_opcion').addEventListener('click', function () {
        const contenedor = document.getElementById('opciones_nuevas');
        const html = `
        <div class="mb-2 border p-2 rounded d-flex align-items-center gap-2">
            <input type="text" class="form-control" name="opciones_nuevas[${contador}][texto_opcion]" placeholder="Texto de opción">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="opciones_nuevas[${contador}][es_correcta]" value="1">
                <label class="form-check-label">Correcta</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="opciones_nuevas[${contador}][estado_opcion]" value="1" checked>
                <label class="form-check-label">Activa</label>
            </div>
            <button type="button" class="btn btn-sm btn-danger" onclick="this.parentElement.remove()">Eliminar</button>
        </div>`;
        contenedor.insertAdjacentHTML('beforeend', html);
        contador++;
    });
</script>

@endsection
