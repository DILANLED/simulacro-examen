@php
  $u = $usuario;
@endphp

<div class="mb-3">
  <label class="form-label">Nombre</label>
  <input
    class="form-control @error('nombre_usuario') is-invalid @enderror"
    name="nombre_usuario"
    value="{{ old('nombre_usuario', $u->nombre_usuario ?? '') }}"
  />
  @error('nombre_usuario') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
  <label class="form-label">Login</label>
  <input
    class="form-control @error('nombre_login_usuario') is-invalid @enderror"
    name="nombre_login_usuario"
    value="{{ old('nombre_login_usuario', $u->nombre_login_usuario ?? '') }}"
  />
  @error('nombre_login_usuario') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
  <label class="form-label">
    Contraseña {{ ($modo ?? '') === 'edit' ? '(dejar vacío para no cambiar)' : '' }}
  </label>
  <input
    type="password"
    class="form-control @error('password_usuario') is-invalid @enderror"
    name="password_usuario"
    value=""
  />
  @error('password_usuario') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
  <label class="form-label">Estado</label>
  <select class="form-select @error('estado_usuario') is-invalid @enderror" name="estado_usuario">
    @php $estado = old('estado_usuario', $u->estado_usuario ?? 1); @endphp
    <option value="1" {{ (int)$estado === 1 ? 'selected' : '' }}>Activo (1)</option>
    <option value="0" {{ (int)$estado === 0 ? 'selected' : '' }}>Inactivo (0)</option>
  </select>
  @error('estado_usuario') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
  <label class="form-label">Rol</label>
  @php $rolSel = old('id_rol', $u->id_rol ?? null); @endphp

  <select name="id_rol" class="form-select @error('id_rol') is-invalid @enderror">
    <option value="">-- Seleccione un rol --</option>

    @foreach($roles as $r)
      <option value="{{ $r->id_rol }}" {{ (string)$rolSel === (string)$r->id_rol ? 'selected' : '' }}>
        {{ $r->nombre_rol }}
      </option>
    @endforeach
  </select>

  @error('id_rol') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
