<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-soft antialiased">
        <div class="flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
            <div class="flex w-full max-w-sm flex-col gap-2">
                <a href="{{ route('welcome') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                    <span class="flex h-12 w-12 mb-1 items-center justify-center rounded-md bg-highlight">
                        <span class="text-3xl">🏆</span>
                    </span>
                    <span class="sr-only">NFL Picks League</span>
                </a>
                <div class="flex flex-col gap-6 bg-card rounded-lg shadow-lg p-8">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
