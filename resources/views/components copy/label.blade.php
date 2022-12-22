@props(['value'])

<label {{ $attributes->merge(['class' => 'col-form-label text-right']) }}>
    {{ $value ?? $slot }}
</label>
