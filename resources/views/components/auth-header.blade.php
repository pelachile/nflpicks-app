@props([
    'title',
    'description',
])

<div class="flex w-full flex-col text-center">
    <h1 class="text-3xl font-bold text-primary">{{ $title }}</h1>
    <p class="mt-2 text-primary/60">{{ $description }}</p>
</div>
