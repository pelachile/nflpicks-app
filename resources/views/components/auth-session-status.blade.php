@props([
    'status',
])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-highlight bg-highlight/10 px-4 py-2 rounded-md']) }}>
        {{ $status }}
    </div>
@endif
