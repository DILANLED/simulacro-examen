@php
  $r = $rol;
@endphp

<div class="mb-3">
  <label class="form-label">Nombre del rol</label>
  <input
    class="form-control @error('nombre_rol') is-invalid @enderror"
    name="nombre_rol"
    value="{{ old('nombre_rol', $r->nombre_rol ?? '') }}"
  />
  @error('nombre_rol') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
  <label class="form-label">Estado</label>
  @php $estado = old('estado_rol', $r->estado_rol ?? 1); @endphp
  <select class="form-select @error('estado_rol') is-invalid @enderror" name="estado_rol">
    <option value="1" {{ (int)$estado === 1 ? 'selected' : '' }}>Activo (1)</option>
    <option value="0" {{ (int)$estado === 0 ? 'selected' : '' }}>Inactivo (0)</option>
  </select>
  @error('estado_rol') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
