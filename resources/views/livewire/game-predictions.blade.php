<div class="max-w-6xl mx-auto p-6">
    <div class="bg-card rounded-lg shadow-md p-6 mb-6">
        <h1 class="text-3xl font-bold text-primary mb-4">
            NFL Week {{ $currentWeek }} Predictions
        </h1>

        @if($predictionsClosed)
            <div class="bg-tomato/10 border border-tomato/30 text-tomato px-4 py-3 rounded mb-4">
                <strong>Predictions Closed:</strong> The first game of the week has started. No more predictions can be made for Week {{ $currentWeek }}.
            </div>
        @else
            <div class="bg-highlight/10 border border-highlight/30 text-primary px-4 py-3 rounded mb-4">
                <strong>Predictions Open:</strong> Make your picks before the first game starts!
            </div>
        @endif
    </div>

    {{-- Flash messages --}}
    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-tomato/10 border border-tomato/30 text-tomato px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    {{-- Games list --}}
    <div class="space-y-6">
        @forelse($games as $game)
            <div class="bg-card rounded-lg shadow-md p-6 {{ !$game['can_predict'] ? 'opacity-75' : '' }}">
                <div class="flex justify-between items-center mb-4">
                    <div class="text-lg font-semibold text-primary">
                        {{ \Carbon\Carbon::parse($game['date_time'])->format('l, M j - g:i A T') }}
                        @if(!$game['can_predict'])
                            <span class="ml-2 px-2 py-1 bg-tomato/10 text-tomato text-xs rounded">
                                Predictions Closed
                            </span>
                        @endif
                    </div>
                    <div class="text-sm text-primary/60">
                        {{ $game['venue']['name'] ?? 'TBD' }}, {{ $game['venue']['city'] ?? '' }}
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    {{-- Away Team --}}
                    @if($game['away_team'])
                        <div
                            @if($game['can_predict']) wire:click="makePrediction({{ $game['id'] }}, {{ $game['away_team']['id'] }})" @endif
                        class="relative p-4 rounded-lg transition-all duration-200 border-2 {{
                                !$game['can_predict'] ? 'cursor-not-allowed' : 'cursor-pointer'
                            }} {{
                                isset($predictions[$game['id']]) && $predictions[$game['id']] == $game['away_team']['id']
                                    ? 'border-highlight bg-highlight/10 shadow-lg'
                                    : 'border-primary/20 bg-soft/30 ' . ($game['can_predict'] ? 'hover:border-primary/40 hover:shadow-md' : '')
                            }}"
                        >
                            <div class="flex items-center space-x-3">
                                @if($game['away_team']['logo_url'])
                                    <img
                                            src="{{ $game['away_team']['logo_url'] }}"
                                            alt="{{ $game['away_team']['name'] }} logo"
                                            class="w-12 h-12 object-contain"
                                    >
                                @else
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-soft font-bold text-lg bg-primary">
                                        {{ $game['away_team']['abbreviation'] }}
                                    </div>
                                @endif
                                <div>
                                    <h3 class="font-bold text-lg text-primary">{{ $game['away_team']['name'] }}</h3>
                                    <p class="text-sm text-primary/60">Away</p>
                                </div>
                            </div>
                            @if(isset($predictions[$game['id']]) && $predictions[$game['id']] == $game['away_team']['id'])
                                <div class="absolute -top-2 -right-2">
                                    <svg class="w-6 h-6 text-highlight" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Home Team --}}
                    @if($game['home_team'])
                        <div
                            @if($game['can_predict']) wire:click="makePrediction({{ $game['id'] }}, {{ $game['home_team']['id'] }})" @endif
                        class="relative p-4 rounded-lg transition-all duration-200 border-2 {{
                                !$game['can_predict'] ? 'cursor-not-allowed' : 'cursor-pointer'
                            }} {{
                                isset($predictions[$game['id']]) && $predictions[$game['id']] == $game['home_team']['id']
                                    ? 'border-highlight bg-highlight/10 shadow-lg'
                                    : 'border-primary/20 bg-card ' . ($game['can_predict'] ? 'hover:border-primary/40 hover:shadow-md' : '')
                            }}"
                        >
                            <div class="flex items-center space-x-3">
                                @if($game['home_team']['logo_url'])
                                    <img
                                            src="{{ $game['home_team']['logo_url'] }}"
                                            alt="{{ $game['home_team']['name'] }} logo"
                                            class="w-12 h-12 object-contain"
                                    >
                                @else
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-soft font-bold text-lg bg-primary">
                                        {{ $game['home_team']['abbreviation'] }}
                                    </div>
                                @endif
                                <div>
                                    <h3 class="font-bold text-lg text-primary">{{ $game['home_team']['name'] }}</h3>
                                    <p class="text-sm text-primary/60">Home</p>
                                </div>
                            </div>
                            @if(isset($predictions[$game['id']]) && $predictions[$game['id']] == $game['home_team']['id'])
                                <div class="absolute -top-2 -right-2">
                                    <svg class="w-6 h-6 text-highlight" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                {{-- Show prediction status --}}
                @if(isset($predictions[$game['id']]))
                    @php
                        $predictedTeam = $game['home_team']['id'] == $predictions[$game['id']] ? $game['home_team'] : $game['away_team'];
                    @endphp
                    <div class="mt-4 p-3 bg-highlight/10 border border-highlight/30 rounded-lg">
                        <p class="text-primary font-medium">
                            ✅ Your prediction: {{ $predictedTeam['name'] }} will win
                        </p>
                    </div>
                @endif
            </div>
        @empty
            <div class="text-center py-12 bg-card rounded-lg shadow-md">
                <p class="text-primary/60">No games found for Week {{ $currentWeek }}</p>
            </div>
        @endforelse
    </div>
</div>
