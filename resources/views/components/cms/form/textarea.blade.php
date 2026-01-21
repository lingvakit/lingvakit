@props([
    'name',
    'label',
    'value',
    'rows' => 3,
    'required' => false,
    'placeholder' => '',
])

<div class="form-group row d-flex align-items-center mb-5">
    <label class="col-lg-3 form-control-label">
        {{ $label }}
        @if($required)
            <span class="text-danger ml-2">*</span>
        @endif
    </label>
    <div class="col-lg-9">
        <textarea
                name="{{ $name }}"
                rows="{{ $rows }}"
                placeholder="{{ $placeholder }}"
                class="form-control @error($name) is-invalid @enderror"
        >{{old($name, $value ?? null)}}</textarea>

        @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>