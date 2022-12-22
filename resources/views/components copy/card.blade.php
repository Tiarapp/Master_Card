<div {{ $attributes->merge(['class' => 'card']) }}>
    <div class="card-header">
        <h3 class="card-title">
            {{ $title }}
        </h3>

        @if(!empty($tools))
            <div class="card-tools">
                {{ $tools }}
            </div>
        @endif
    </div>
    <div class="card-body">
        {{ $slot }}
    </div>
    @if(!empty($footer))
        <div class="card-footer">
            {{ $footer }}
        </div>
    @endif
</div>