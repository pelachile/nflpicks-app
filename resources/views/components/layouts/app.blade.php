{{-- resources/views/layouts/app.blade.php --}}
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-soft">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Theme Script (must be loaded early to prevent flash) -->
    <script>
        (function() {
            function applyTheme() {
                const theme = localStorage.getItem('theme') || 'system';
                if (theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            }
            
            // Apply theme immediately
            applyTheme();
            
            // Listen for system theme changes
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                if (localStorage.getItem('theme') === 'system') {
                    applyTheme();
                }
            });
            
            // Listen for storage changes (for cross-tab updates)
            window.addEventListener('storage', (e) => {
                if (e.key === 'theme') {
                    applyTheme();
                }
            });
        })();
    </script>

    <!-- Livewire Styles -->
    @livewireStyles
</head>
<body class="h-full bg-soft">
<div class="min-h-full">
    @include('components.layouts.app.sidebar')

    <!-- Main content -->
    <div class="lg:pl-72">
        <main class="py-6">
            <div class="px-4 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>
    </div>
</div>

<!-- Livewire Scripts -->
@livewireScripts
</body>
</html>
