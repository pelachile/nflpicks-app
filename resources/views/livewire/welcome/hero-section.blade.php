{{-- resources/views/livewire/welcome/hero-section.blade.php --}}
<section class="relative h-screen flex items-center justify-center text-center">
    <!-- Background Image -->
    <img
        src="{{ asset('images/hero-background.jpeg') }}"
        alt="Football Background"
        class="absolute inset-0 w-full h-full object-cover opacity-60 grayscale mix-blend-multiply z-0"
    />

    <!-- Overlay Tint -->
    <div class="absolute inset-0 bg-primary/70 z-0"></div>

    <!-- Hero Content -->
    <div class="z-10 px-4">
        <h1 class="text-4xl md:text-6xl font-extrabold leading-tight uppercase text-soft drop-shadow-md">
            Challenge Your Friends<br />Every NFL Week
        </h1>
        <p class="mt-4 text-lg text-[#F3B562] tracking-wide">
            Make picks. Track wins. Talk trash.
        </p>

        <a href="{{ route('register') }}"
        wire:navigate
        class="mt-6 inline-block bg-[#f06060] hover:bg-highlight text-white font-bold px-6 py-3 rounded shadow transition"
        >
        Create Your Group
        </a>
    </div>
</section>
