{{-- resources/views/livewire/welcome/hero-section.blade.php --}}
<section class="relative h-screen flex items-center justify-center text-center overflow-hidden">
    <!-- Background Image with Enhanced Overlay -->
    <div class="absolute inset-0">
        <img
            src="{{ asset('images/hero-background.jpeg') }}"
            alt="Football Background"
            class="w-full h-full object-cover"
        />
        <div class="absolute inset-0 bg-gradient-to-br from-primary/80 via-primary/70 to-primary/60"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
    </div>

    <!-- Hero Content -->
    <div class="relative z-10 max-w-4xl mx-auto px-6">
        <!-- Trophy Icon -->
        <div class="mb-6">
            <span class="inline-block text-6xl md:text-7xl animate-pulse">🏆</span>
        </div>
        
        <!-- Main Headline -->
        <h1 class="text-4xl md:text-6xl lg:text-7xl font-black leading-tight text-white mb-6">
            <span class="block">Challenge Your Friends</span>
            <span class="block text-highlight">
                Every NFL Week
            </span>
        </h1>
        
        <!-- Subheading -->
        <p class="text-lg md:text-xl text-gray-200 mb-8 max-w-2xl mx-auto leading-relaxed">
            Make picks. Track wins. Talk trash. The ultimate NFL prediction game for you and your crew.
        </p>

        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="{{ route('register') }}"
               wire:navigate
               class="group relative inline-flex items-center justify-center px-8 py-4 text-lg font-bold text-white bg-gradient-to-r from-tomato to-highlight rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                <span class="relative z-10">Create Your Group</span>
                <div class="absolute inset-0 bg-gradient-to-r from-highlight to-tomato rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </a>
            
            @guest
                <a href="{{ route('login') }}"
                   wire:navigate
                   class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white border-2 border-white rounded-lg hover:bg-white hover:text-primary transition-all duration-300">
                    Sign In
                </a>
            @endguest
        </div>

        <!-- Stats or Features -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6 max-w-3xl mx-auto">
            <div class="text-center">
                <div class="text-2xl md:text-3xl font-bold text-white mb-2">17</div>
                <div class="text-sm text-gray-300">Weekly Games</div>
            </div>
            <div class="text-center">
                <div class="text-2xl md:text-3xl font-bold text-white mb-2">18</div>
                <div class="text-sm text-gray-300">Week Season</div>
            </div>
            <div class="text-center">
                <div class="text-2xl md:text-3xl font-bold text-white mb-2">∞</div>
                <div class="text-sm text-gray-300">Bragging Rights</div>
            </div>
        </div>
    </div>
</section>
