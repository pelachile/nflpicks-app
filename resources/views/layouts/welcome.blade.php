{{-- resources/views/layouts/welcome.blade.php --}}
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'NFL Pick\'em League' }}</title>
    
    <link rel="icon" href="/favicon.ico?v={{ time() }}" sizes="any">
    <link rel="icon" href="/favicon.svg?v={{ time() }}" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-soft text-primary font-sans">

<!-- Navigation -->
<nav
    x-data="{
            open: false,
            scrolled: false,
            init() {
                window.addEventListener('scroll', () => {
                    this.scrolled = window.scrollY > window.innerHeight * 0.7;
                });
            }
        }"
    :class="scrolled ? 'bg-primary/90 backdrop-blur-sm shadow-lg' : 'bg-transparent'"
    class="fixed top-0 w-full z-50 text-soft transition-all duration-300"
>
    <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
        <!-- Logo -->
        <div class="flex items-center space-x-2">
            <span class="text-2xl">🏆</span>
            <span class="text-lg font-bold">{{ config('app.name') }}</span>
        </div>

        <!-- Desktop Menu -->
        <div class="hidden md:flex space-x-6 font-medium items-center">
            <a href="{{ route('welcome') }}" class="hover:text-highlight transition-colors">Home</a>
            @guest
                <a href="{{ route('login') }}" wire:navigate class="hover:text-highlight transition-colors">Login</a>

                <a href="{{ route('register') }}"
                wire:navigate
                class="border border-current rounded-full px-4 py-1 bg-soft text-primary hover:bg-highlight hover:text-white transition-all"
                >
                Sign Up
                </a>
            @else
                <a href="{{ route('dashboard') }}" wire:navigate class="hover:text-highlight transition-colors">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="hover:text-highlight transition-colors">Logout</button>
                </form>
            @endguest
        </div>

        <!-- Mobile menu button -->
        <button @click="open = !open" class="md:hidden focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path :class="{ 'hidden': open }" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{ 'hidden': !open }" stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" @click.away="open = false" class="md:hidden px-6 pb-4 space-y-4 bg-primary text-soft">
        <a href="{{ route('welcome') }}" class="block hover:text-highlight">Home</a>
        @guest
            <a href="{{ route('login') }}" wire:navigate class="block hover:text-highlight">Login</a>
            <a href="{{ route('register') }}" wire:navigate class="block bg-soft text-primary px-4 py-2 rounded hover:bg-highlight hover:text-white transition-all">Sign Up</a>
        @else
            <a href="{{ route('dashboard') }}" wire:navigate class="block hover:text-highlight">Dashboard</a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="block hover:text-highlight">Logout</button>
            </form>
        @endguest
    </div>
</nav>

<!-- Main Content -->
<main>
    {{ $slot }}
</main>

<!-- Footer -->
<footer class="bg-primary text-soft text-sm py-8 px-6">
    <div class="max-w-6xl mx-auto flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
        <div class="text-center md:text-left font-semibold">
            © 2025 {{ config('app.name') }}
        </div>
        <div class="text-center text-soft/80">Not affiliated with the NFL.</div>
        <div class="text-center md:text-right space-x-4">
            <a href="#" class="hover:underline">Privacy</a>
            <a href="#" class="hover:underline">Terms</a>
        </div>
    </div>
</footer>
@livewireScripts
</body>
</html>
