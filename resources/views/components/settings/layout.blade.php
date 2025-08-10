<div class="flex items-start max-md:flex-col">
    <div class="me-10 w-full pb-4 md:w-[220px]">
        <nav class="space-y-2">
            <a href="{{ route('settings.profile') }}" wire:navigate class="block px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('settings.profile') ? 'bg-primary text-white' : 'text-primary hover:bg-primary/10' }}">
                {{ __('Profile') }}
            </a>
            <a href="{{ route('settings.password') }}" wire:navigate class="block px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('settings.password') ? 'bg-primary text-white' : 'text-primary hover:bg-primary/10' }}">
                {{ __('Password') }}
            </a>
            <a href="{{ route('settings.appearance') }}" wire:navigate class="block px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('settings.appearance') ? 'bg-primary text-white' : 'text-primary hover:bg-primary/10' }}">
                {{ __('Appearance') }}
            </a>
        </nav>
    </div>

    <div class="w-full border-t border-primary/10 md:hidden mb-6"></div>

    <div class="flex-1 self-stretch max-md:pt-6">
        <h2 class="text-2xl font-bold text-primary">{{ $heading ?? '' }}</h2>
        <p class="text-sm text-primary/60 mt-1">{{ $subheading ?? '' }}</p>

        <div class="mt-5 w-full max-w-lg">
            {{ $slot }}
        </div>
    </div>
</div>
