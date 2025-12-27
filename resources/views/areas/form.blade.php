@php
  $a = $area ?? null;
@endphp

<div class="mb-3">
  <label class="form-label">Nombre del Área</label>
  <input class="form-control @error('nombre_area') is-invalid @enderror"
         name="nombre_area"
         value="{{ old('nombre_area', $a->nombre_area ?? '') }}">
  @error('nombre_area') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
  <label class="form-label">Número de preguntas</label>
  <input type="number"
         class="form-control @error('n_preguntas') is-invalid @enderror"
         name="n_preguntas"
         value="{{ old('n_preguntas', $a->n_preguntas ?? '') }}">
  @error('n_preguntas') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
  <label class="form-label">Carrera</label>
  @php $selected = old('id_carrera', $a->id_carrera ?? ''); @endphp
  <select class="form-select @error('id_carrera') is-invalid @enderror" name="id_carrera">
    <option value="">-- Seleccione --</option>
    @foreach($carreras as $c)
      <option value="{{ $c->id_carrera }}" {{ (int)$selected === (int)$c->id_carrera ? 'selected' : '' }}>
        {{ $c->nombre_carrera }}
      </option>
    @endforeach
  </select>
  @error('id_carrera') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
  <label class="form-label">Estado</label>
  @php $estado = old('estado_area', $a->estado_area ?? 1); @endphp
  <select class="form-select @error('estado_area') is-invalid @enderror" name="estado_area">
    <option value="1" {{ (int)$estado === 1 ? 'selected' : '' }}>Activo</option>
    <option value="0" {{ (int)$estado === 0 ? 'selected' : '' }}>Inactivo</option>
  </select>
  @error('estado_area') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
