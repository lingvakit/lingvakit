@props([
    'label',
    'name',
    'options',
    'selected' => null
])

<div class="row">
    <div class="col-12">
        <h4 class="mb-4">{{ $label }}</h4>
    </div>
    <div class="col-xl-2">
        <div class="mb-3">
            @foreach($options as $value => $text)
                @php
                    $id = "{$name}_{$value}";
                    $isChecked = old($name, $selected) === $value;
                @endphp

                <div class="styled-radio">
                    <input
                            type="radio"
                            name="{{ $name }}"
                            id="{{ $id }}"
                            value="{{ $value }}"
                            {{ $isChecked ? 'checked' : '' }}>
                    <label for="{{ $id }}">
                        {{ $text }}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
</div>

