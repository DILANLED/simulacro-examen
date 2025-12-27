@php
  $p = $pregunta ?? null;
  $opciones = $p ? $p->opciones : [];
@endphp

<div class="mb-3">
  <label class="form-label">Área</label>
  <select name="id_area" class="form-select @error('id_area') is-invalid @enderror">
    <option value="">-- Seleccione Área --</option>
    @foreach($areas as $area)
      <option value="{{ $area->id_area }}" {{ old('id_area', $p->id_area ?? '') == $area->id_area ? 'selected' : '' }}>
        {{ $area->nombre_area }}
      </option>
    @endforeach
  </select>
  @error('id_area') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
  <label class="form-label">Texto de la pregunta</label>
  <textarea name="texto_pregunta" class="form-control @error('texto_pregunta') is-invalid @enderror">{{ old('texto_pregunta', $p->texto_pregunta ?? '') }}</textarea>
  @error('texto_pregunta') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
  <label class="form-label">Estado</label>
  @php $estado = old('estado_pregunta', $p->estado_pregunta ?? 1); @endphp
  <select name="estado_pregunta" class="form-select @error('estado_pregunta') is-invalid @enderror">
    <option value="1" {{ (int)$estado === 1 ? 'selected' : '' }}>Activo</option>
    <option value="0" {{ (int)$estado === 0 ? 'selected' : '' }}>Inactivo</option>
  </select>
  @error('estado_pregunta') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<hr>

<h5>Opciones</h5>
<div id="opciones-container">
  @if(old('opciones'))
    @foreach(old('opciones') as $i => $opc)
      <div class="opcion mb-2 border p-2 rounded">
        <div class="d-flex gap-2 align-items-center">
          <input type="text" name="opciones[{{ $i }}][texto_opcion]" class="form-control" placeholder="Texto opción" value="{{ $opc['texto_opcion'] }}">
          <label class="form-check-label ms-2">
            Correcta
            <input type="checkbox" name="opciones[{{ $i }}][es_correcta]" value="1" {{ isset($opc['es_correcta']) && $opc['es_correcta'] ? 'checked' : '' }}>
          </label>
          <select name="opciones[{{ $i }}][estado_opcion]" class="form-select ms-2" style="width:auto">
            <option value="1" {{ $opc['estado_opcion'] == 1 ? 'selected' : '' }}>Activo</option>
            <option value="0" {{ $opc['estado_opcion'] == 0 ? 'selected' : '' }}>Inactivo</option>
          </select>
          <button type="button" class="btn btn-sm btn-danger ms-auto remove-opcion">Eliminar</button>
        </div>
      </div>
    @endforeach
  @elseif($opciones->count())
    @foreach($opciones as $i => $opc)
      <div class="opcion mb-2 border p-2 rounded">
        <div class="d-flex gap-2 align-items-center">
          <input type="text" name="opciones[{{ $i }}][texto_opcion]" class="form-control" placeholder="Texto opción" value="{{ $opc->texto_opcion }}">
          <label class="form-check-label ms-2">
            Correcta
            <input type="checkbox" name="opciones[{{ $i }}][es_correcta]" value="1" {{ $opc->es_correcta ? 'checked' : '' }}>
          </label>
          <select name="opciones[{{ $i }}][estado_opcion]" class="form-select ms-2" style="width:auto">
            <option value="1" {{ $opc->estado_opcion == 1 ? 'selected' : '' }}>Activo</option>
            <option value="0" {{ $opc->estado_opcion == 0 ? 'selected' : '' }}>Inactivo</option>
          </select>
          <button type="button" class="btn btn-sm btn-danger ms-auto remove-opcion">Eliminar</button>
        </div>
      </div>
    @endforeach
  @endif
</div>

<button type="button" id="add-opcion" class="btn btn-sm btn-success mt-2">Agregar opción</button>

<hr>

@push('scripts')
<script>
let opcionIndex = {{ old('opciones') ? count(old('opciones')) : ($opciones->count() ?? 0) }};

document.getElementById('add-opcion').addEventListener('click', function() {
    const container = document.getElementById('opciones-container');
    const div = document.createElement('div');
    div.classList.add('opcion', 'mb-2', 'border', 'p-2', 'rounded');
    div.innerHTML = `
      <div class="d-flex gap-2 align-items-center">
        <input type="text" name="opciones[${opcionIndex}][texto_opcion]" class="form-control" placeholder="Texto opción">
        <label class="form-check-label ms-2">
          Correcta
          <input type="checkbox" name="opciones[${opcionIndex}][es_correcta]" value="1">
        </label>
        <select name="opciones[${opcionIndex}][estado_opcion]" class="form-select ms-2" style="width:auto">
          <option value="1" selected>Activo</option>
          <option value="0">Inactivo</option>
        </select>
        <button type="button" class="btn btn-sm btn-danger ms-auto remove-opcion">Eliminar</button>
      </div>
    `;
    container.appendChild(div);
    opcionIndex++;
});

document.addEventListener('click', function(e){
    if(e.target && e.target.classList.contains('remove-opcion')){
        e.target.closest('.opcion').remove();
    }
});
</script>
@endpush
@php
  $p = $pregunta ?? null;
  $opciones = $p ? $p->opciones : [];
@endphp

<div class="mb-3">
  <label class="form-label">Área</label>
  <select name="id_area" class="form-select @error('id_area') is-invalid @enderror">
    <option value="">-- Seleccione Área --</option>
    @foreach($areas as $area)
      <option value="{{ $area->id_area }}" {{ old('id_area', $p->id_area ?? '') == $area->id_area ? 'selected' : '' }}>
        {{ $area->nombre_area }}
      </option>
    @endforeach
  </select>
  @error('id_area') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
  <label class="form-label">Texto de la pregunta</label>
  <textarea name="texto_pregunta" class="form-control @error('texto_pregunta') is-invalid @enderror">{{ old('texto_pregunta', $p->texto_pregunta ?? '') }}</textarea>
  @error('texto_pregunta') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
  <label class="form-label">Estado</label>
  @php $estado = old('estado_pregunta', $p->estado_pregunta ?? 1); @endphp
  <select name="estado_pregunta" class="form-select @error('estado_pregunta') is-invalid @enderror">
    <option value="1" {{ (int)$estado === 1 ? 'selected' : '' }}>Activo</option>
    <option value="0" {{ (int)$estado === 0 ? 'selected' : '' }}>Inactivo</option>
  </select>
  @error('estado_pregunta') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<hr>

<h5>Opciones</h5>
<div id="opciones-container">
  @if(old('opciones'))
    @foreach(old('opciones') as $i => $opc)
      <div class="opcion mb-2 border p-2 rounded">
        <div class="d-flex gap-2 align-items-center">
          <input type="text" name="opciones[{{ $i }}][texto_opcion]" class="form-control" placeholder="Texto opción" value="{{ $opc['texto_opcion'] }}">
          <label class="form-check-label ms-2">
            Correcta
            <input type="checkbox" name="opciones[{{ $i }}][es_correcta]" value="1" {{ isset($opc['es_correcta']) && $opc['es_correcta'] ? 'checked' : '' }}>
          </label>
          <select name="opciones[{{ $i }}][estado_opcion]" class="form-select ms-2" style="width:auto">
            <option value="1" {{ $opc['estado_opcion'] == 1 ? 'selected' : '' }}>Activo</option>
            <option value="0" {{ $opc['estado_opcion'] == 0 ? 'selected' : '' }}>Inactivo</option>
          </select>
          <button type="button" class="btn btn-sm btn-danger ms-auto remove-opcion">Eliminar</button>
        </div>
      </div>
    @endforeach
  @elseif($opciones->count())
    @foreach($opciones as $i => $opc)
      <div class="opcion mb-2 border p-2 rounded">
        <div class="d-flex gap-2 align-items-center">
          <input type="text" name="opciones[{{ $i }}][texto_opcion]" class="form-control" placeholder="Texto opción" value="{{ $opc->texto_opcion }}">
          <label class="form-check-label ms-2">
            Correcta
            <input type="checkbox" name="opciones[{{ $i }}][es_correcta]" value="1" {{ $opc->es_correcta ? 'checked' : '' }}>
          </label>
          <select name="opciones[{{ $i }}][estado_opcion]" class="form-select ms-2" style="width:auto">
            <option value="1" {{ $opc->estado_opcion == 1 ? 'selected' : '' }}>Activo</option>
            <option value="0" {{ $opc->estado_opcion == 0 ? 'selected' : '' }}>Inactivo</option>
          </select>
          <button type="button" class="btn btn-sm btn-danger ms-auto remove-opcion">Eliminar</button>
        </div>
      </div>
    @endforeach
  @endif
</div>

<button type="button" id="add-opcion" class="btn btn-sm btn-success mt-2">Agregar opción</button>

<hr>

@push('scripts')
<script>
let opcionIndex = {{ old('opciones') ? count(old('opciones')) : ($opciones->count() ?? 0) }};

document.getElementById('add-opcion').addEventListener('click', function() {
    const container = document.getElementById('opciones-container');
    const div = document.createElement('div');
    div.classList.add('opcion', 'mb-2', 'border', 'p-2', 'rounded');
    div.innerHTML = `
      <div class="d-flex gap-2 align-items-center">
        <input type="text" name="opciones[${opcionIndex}][texto_opcion]" class="form-control" placeholder="Texto opción">
        <label class="form-check-label ms-2">
          Correcta
          <input type="checkbox" name="opciones[${opcionIndex}][es_correcta]" value="1">
        </label>
        <select name="opciones[${opcionIndex}][estado_opcion]" class="form-select ms-2" style="width:auto">
          <option value="1" selected>Activo</option>
          <option value="0">Inactivo</option>
        </select>
        <button type="button" class="btn btn-sm btn-danger ms-auto remove-opcion">Eliminar</button>
      </div>
    `;
    container.appendChild(div);
    opcionIndex++;
});

document.addEventListener('click', function(e){
    if(e.target && e.target.classList.contains('remove-opcion')){
        e.target.closest('.opcion').remove();
    }
});
</script>
@endpush
