{{-- resources/views/livewire/welcome/leaderboard-section.blade.php --}}
<section class="bg-white py-16 px-6 text-primary">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        <!-- LEFT COLUMN -->
        <div class="text-center md:text-left space-y-4">
            <h2 class="text-3xl md:text-4xl font-extrabold uppercase tracking-wide">
                Top of the Leaderboard
            </h2>
            <h3 class="text-xl md:text-2xl font-semibold">
                Think you can Pick 'Em Better?
            </h3>
            <p class="text-primary/70">Start a group and invite your crew.</p>
            <a href="{{ route('register') }}"
            wire:navigate
            class="mt-6 inline-block bg-[#F06060] hover:bg-highlight text-white font-bold px-6 py-3 rounded shadow transition"
            >
            Create Your Group
            </a>
        </div>

        <!-- RIGHT COLUMN -->
        <div class="w-full max-w-md md:ml-auto mx-auto bg-soft border border-primary/20 rounded-lg shadow">
            <ul class="divide-y divide-primary/10">
                @foreach($sampleLeaders as $leader)
                    <li class="flex items-center justify-between px-6 py-4">
                        <div class="flex items-center space-x-2">
                            <span class="text-xl">{{ $leader['emoji'] }}</span>
                            <span class="font-semibold">{{ $leader['name'] }}</span>
                        </div>
                        <span class="font-bold text-tomato text-lg">{{ $leader['record'] }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>
