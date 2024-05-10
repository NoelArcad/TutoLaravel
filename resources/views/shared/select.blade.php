@php
    $label = $label ?? null;
    $class = $class ?? null;
    $name = $name ?? '';
    $value = $value ?? '';
    $label = $label ?? ucfirst($name);
@endphp

<div class="form-group {{ $class }}">
    <label for="{{ $name }}">{{ $label }}</label>
   
    <select name="{{ $name }}[]" id="{{ $name }}" multiple>

        @foreach($options as $k => $v)

        <option {{ $value->contains($k) ? 'selected' : '' }} value="{{ $k }}">{{ $v }}</option>

        @endforeach

    </select>

    @error($name)
        <div class="invalid-feedback">
             {{ $message }}    
        </div>
    @enderror
</div>
