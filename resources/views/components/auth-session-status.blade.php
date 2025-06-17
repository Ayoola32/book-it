@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium alert alert-success']) }}>
        {{ $status }}
    </div>
@endif
