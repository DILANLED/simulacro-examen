@php
  $c = $carrera;
@endphp

<div class="mb-3">
  <label class="form-label">Nombre de la carrera</label>
  <input
    class="form-control @error('nombre_carrera') is-invalid @enderror"
    name="nombre_carrera"
    value="{{ old('nombre_carrera', $c->nombre_carrera ?? '') }}"
  />
  @error('nombre_carrera')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>

<div class="mb-3">
  <label class="form-label">Gestión</label>
  <input
    class="form-control @error('gestion_carrera') is-invalid @enderror"
    name="gestion_carrera"
    value="{{ old('gestion_carrera', $c->gestion_carrera ?? '') }}"
  />
  @error('gestion_carrera')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>

<div class="mb-3">
  <label class="form-label">Estado</label>
  @php $estado = old('estado_carrera', $c->estado_carrera ?? 1); @endphp
  <select
    class="form-select @error('estado_carrera') is-invalid @enderror"
    name="estado_carrera"
  >
    <option value="1" {{ (int)$estado === 1 ? 'selected' : '' }}>
      Activo (1)
    </option>
    <option value="0" {{ (int)$estado === 0 ? 'selected' : '' }}>
      Inactivo (0)
    </option>
  </select>
  @error('estado_carrera')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>
