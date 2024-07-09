@php
    $errors = is_array($errors) ? $errors : $errors->get($attributes['name']);
    $attributes = $attributes->merge([
        'class' => 'form-control ' . ($errors ? 'is-invalid' : ''),
        'value' => old($attributes['name']),
        'type' => 'text',
        'id' => $attributes['name'].'-input',
    ])->except(['errors']);
@endphp

<div class="mb-3">
    <label class="form-label" for="{{ $attributes['id'] }}">{{  $attributes['label'] ?? ucfirst($attributes['name']) }}</label>
    <input {{ $attributes }} />

    @if (count($errors))
        <div class="invalid-feedback">
            @foreach ($errors as $error)
                {{ $error }} <br>
            @endforeach
        </div>
    @endif
</div>
