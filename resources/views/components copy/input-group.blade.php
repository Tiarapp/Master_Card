<div {{ $attributes->merge(['class' => 'input-group']) }}>
    {{ $slot }}
    <div class="input-group-append">
        <div class="input-group-text">
            {{ $icon }}
        </div>
    </div>
</div>