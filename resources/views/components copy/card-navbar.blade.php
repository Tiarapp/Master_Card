<div {{ $attributes->merge(['class' => 'card card-lightblue card-tabs']) }}>
    <div class="card-header p-0 pt-1">
        <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
            {{ $header }}
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="custom-tabs-two-tabContent">
            <div class="tab-pane fade show active" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
            {{ $slot }}
            </div>
        </div>
    </div>
    @if(!empty($footer))
        <div class="card-footer">
            {{ $footer }}
        </div>
    @endif
</div>