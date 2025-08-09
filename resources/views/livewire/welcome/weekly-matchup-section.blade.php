{{-- resources/views/livewire/welcome/weekly-matchups-section.blade.php --}}
<section class="bg-white py-16 px-6 text-primary">
    <div class="max-w-6xl mx-auto text-center mb-12">
        <h2 class="text-3xl md:text-4xl font-extrabold uppercase tracking-wide mb-2">
            Week {{ $currentWeek }} Matchups
        </h2>
        <p class="text-primary/70 text-sm">Pick your winners before kickoff!</p>
    </div>

    <div class="max-w-4xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
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
                    <div class="p-4">
                        {{-- Away Team --}}
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center space-x-3">
                                @if($game['away_team'] && $game['away_team']['logo_url'])
                                    <img
                                        src="{{ $game['away_team']['logo_url'] }}"
                                        alt="{{ $game['away_team']['name'] }}"
                                        class="w-8 h-8 object-contain"
                                    />
                                @endif
                                <div>
                                    <p class="font-bold text-sm">{{ $game['away_team']['name'] ?? 'TBD' }}</p>
                                    <p class="text-xs text-primary/60">Away</p>
                                </div>
                            </div>
                        </div>

                        {{-- VS --}}
                        <div class="text-center mb-3">
                            <span class="text-xs text-primary/60 font-medium">VS</span>
                        </div>

                        {{-- Home Team --}}
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                @if($game['home_team'] && $game['home_team']['logo_url'])
                                    <img
                                        src="{{ $game['home_team']['logo_url'] }}"
                                        alt="{{ $game['home_team']['name'] }}"
                                        class="w-8 h-8 object-contain"
                                    />
                                @endif
                                <div>
                                    <p class="font-bold text-sm">{{ $game['home_team']['name'] ?? 'TBD' }}</p>
                                    <p class="text-xs text-primary/60">Home</p>
                                </div>
                            </div>
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
