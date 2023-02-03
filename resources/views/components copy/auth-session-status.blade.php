@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'alert alert-success alert-dismissible']) }}>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ $status }}
    </div>
@endif
