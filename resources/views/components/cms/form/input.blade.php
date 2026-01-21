@props([
    'id',
    'name',
    'class' => null,
    'type' => 'text',
    'label',
    'required' => false,
    'placeholder' => '',
    'value' => ''
])

<div class="form-group row d-flex align-items-center mb-5">
    <label class="col-lg-3 form-control-label">
        {{ $label }}
        @if($required)
            <span class="text-danger ml-2">*</span>
        @endif
    </label>
    <div class="col-lg-9">
        <input
                id="{{ $name }}"
                type="{{ $type }}"
                name="{{ $name }}"
                class="@if($class) {{ $class }} @else form-control @endif @error($name) is-invalid @enderror"
                placeholder="{{ $placeholder }}"
                value="{{ old($name, $value) }}"
                @if($required) required @endif>

        @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>