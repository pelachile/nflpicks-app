{{-- resources/views/livewire/welcome/weekly-matchups-section.blade.php --}}
<section class="bg-white py-16 px-6 text-primary">
    <div class="max-w-6xl mx-auto text-center mb-12">
        <h2 class="text-3xl md:text-4xl font-extrabold uppercase tracking-wide mb-2">
            Week {{ $currentWeek }} Matchups
        </h2>
        <p class="text-primary/70 text-sm">Pick your winners before kickoff!</p>
    </div>

    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($featuredGames as $game)
                <div class="bg-white rounded-lg shadow-lg border border-primary/10 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    {{-- Game Header with Date --}}
                    <div class="bg-soft px-4 py-3 border-b border-primary/10 text-center">
                        <p class="text-sm font-semibold text-primary">
                            {{ \Carbon\Carbon::parse($game['date_time'])->format('l, M j') }}
                        </p>
                        <p class="text-xs text-primary/70 mt-1">
                            {{ \Carbon\Carbon::parse($game['date_time'])->format('g:i A T') }}
                        </p>
                        @if($game['venue'])
                            <p class="text-xs text-primary/60 mt-1">
                                {{ $game['venue']['city'] }}, {{ $game['venue']['state'] }}
                            </p>
                        @endif
                    </div>

                    {{-- Teams --}}
                    <div class="p-6">
                        {{-- Away Team --}}
                        <div class="flex items-center justify-center mb-6">
                            @if($game['away_team'] && $game['away_team']['logo_url'])
                                <img
                                    src="{{ $game['away_team']['logo_url'] }}"
                                    alt="{{ $game['away_team']['name'] }}"
                                    class="w-16 h-16 object-contain mr-4"
                                />
                            @endif
                            <p class="font-bold text-lg whitespace-nowrap overflow-hidden text-ellipsis">{{ $game['away_team']['name'] ?? 'TBD' }}</p>
                        </div>

                        {{-- VS --}}
                        <div class="text-center mb-6">
                            <span class="text-lg text-primary/60 font-bold">VS</span>
                        </div>

                        {{-- Home Team --}}
                        <div class="flex items-center justify-center mb-6">
                            @if($game['home_team'] && $game['home_team']['logo_url'])
                                <img
                                    src="{{ $game['home_team']['logo_url'] }}"
                                    alt="{{ $game['home_team']['name'] }}"
                                    class="w-16 h-16 object-contain mr-4"
                                />
                            @endif
                            <p class="font-bold text-lg whitespace-nowrap overflow-hidden text-ellipsis">{{ $game['home_team']['name'] ?? 'TBD' }}</p>
                        </div>

                        {{-- Call to Action --}}

                        <a href="{{ route('register') }}"
                        wire:navigate
                        class="block w-full bg-[#F06060] text-white text-sm font-medium py-2 px-4 rounded hover:bg-highlight transition-colors text-center"
                        >
                        Join to Make Picks
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-primary/60 py-12">
                    <p class="text-lg">No games available for Week {{ $currentWeek }}</p>
                    <p class="text-sm mt-2">Check back when the schedule is released!</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
