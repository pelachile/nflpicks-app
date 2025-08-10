<div class="max-w-7xl mx-auto p-6 space-y-8">
    {{-- Header with Gradient --}}
    <div class="relative bg-gradient-to-b from-primary to-primary/80 rounded-xl shadow-lg overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-primary/10 to-primary/5 backdrop-blur-sm"></div>
        <div class="relative p-8">
            <div class="flex items-center justify-center mb-4">
                <span class="text-4xl mr-3">🏆</span>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white">{{ config('app.name') }}</h1>
            </div>
            <div class="text-center">
                <p class="text-white/80 text-lg">{{ $currentSeasonTypeName }} Week {{ $currentWeek }}, 2025</p>
            </div>
        </div>
    </div>

    {{-- Stats Grid with Enhanced Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- This Week's Predictions --}}
        <div class="bg-gradient-to-br from-card to-soft/20 rounded-xl shadow-lg border border-primary/5 p-6 hover:shadow-xl transition-all duration-300 hover:scale-105">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-highlight to-highlight/80 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.398.815 1.027 1.398 1.8 1.398h.174c.08 0 .157-.031.22-.067.075-.043.158-.097.234-.157.1-.075.206-.15.309-.224.296-.216.514-.467.691-.748a3.468 3.468 0 0 0 .422-.92c.17-.548.267-1.126.267-1.726v-.51H5.904Z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-primary/70 uppercase tracking-wide">This Week's Picks</h3>
                    </div>
                </div>
                @if($userStats['predictions_this_week'] == $userStats['total_games_this_week'] && $userStats['total_games_this_week'] > 0)
                    <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                @endif
            </div>
            <div class="space-y-3">
                <p class="text-3xl font-bold text-primary leading-none">
                    @if($userStats['total_games_this_week'] > 0)
                        {{ $userStats['predictions_this_week'] }} / {{ $userStats['total_games_this_week'] }}
                    @else
                        <span class="text-primary/40">--</span>
                    @endif
                </p>
                <p class="text-sm text-primary/60">Games picked this week</p>
                @if($userStats['total_games_this_week'] > 0)
                    <div class="w-full bg-primary/10 rounded-full h-2">
                        <div class="bg-gradient-to-r from-highlight to-highlight/80 h-2 rounded-full transition-all duration-500"
                             style="width: {{ ($userStats['predictions_this_week'] / $userStats['total_games_this_week']) * 100 }}%"></div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Season Record --}}
        <div class="bg-gradient-to-br from-card to-soft/20 rounded-xl shadow-lg border border-primary/5 p-6 hover:shadow-xl transition-all duration-300 hover:scale-105">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-primary/70 uppercase tracking-wide">Season Record</h3>
                    </div>
                </div>
                @if($userStats['season_percentage'] >= 60)
                    <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                @endif
            </div>
            <div class="space-y-3">
                <p class="text-3xl font-bold text-primary leading-none">
                    @if($userStats['season_total'] > 0)
                        {{ $userStats['season_correct'] }}-{{ $userStats['season_total'] - $userStats['season_correct'] }}
                    @else
                        <span class="text-primary/40">--</span>
                    @endif
                </p>
                <div class="flex items-center justify-between">
                    <p class="text-sm text-primary/60">{{ $userStats['season_percentage'] }}% correct</p>
                    @if($userStats['season_total'] > 0)
                        <div class="flex items-center space-x-1">
                            <div class="w-2 h-2 rounded-full {{ $userStats['season_percentage'] >= 70 ? 'bg-green-500' : ($userStats['season_percentage'] >= 50 ? 'bg-yellow-500' : 'bg-red-500') }}"></div>
                            <span class="text-xs text-primary/50">{{ $userStats['season_total'] }} games</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Latest Week Rank --}}
        <div class="bg-gradient-to-br from-card to-soft/20 rounded-xl shadow-lg border border-primary/5 p-6 hover:shadow-xl transition-all duration-300 hover:scale-105">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 0 0 2.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.228a25.628 25.628 0 0 1 2.916.52 6.003 6.003 0 0 1-5.395 4.972m0 0a6.726 6.726 0 0 1-2.749 1.35m0 0a6.772 6.772 0 0 1-3.044 0" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-primary/70 uppercase tracking-wide">Latest Rank</h3>
                    </div>
                </div>
                @if($userStats['latest_week_rank'] && $userStats['latest_week_rank'] <= 3)
                    <div class="w-8 h-8 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                @endif
            </div>
            <div class="space-y-3">
                <p class="text-3xl font-bold text-primary leading-none">
                    @if($userStats['latest_week_rank'])
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">#{{ $userStats['latest_week_rank'] }}</span>
                    @else
                        <span class="text-primary/40">--</span>
                    @endif
                </p>
                <p class="text-sm text-primary/60">
                    @if($userStats['latest_week_record'])
                        Record: {{ $userStats['latest_week_record'] }}
                    @else
                        No rankings yet
                    @endif
                </p>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="bg-gradient-to-br from-card to-soft/20 rounded-xl shadow-lg border border-primary/5 p-6 hover:shadow-xl transition-all duration-300 hover:scale-105">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-primary/70 uppercase tracking-wide">Quick Actions</h3>
                </div>
            </div>
            <div class="space-y-3">
                <a href="{{ route('predictions') }}" wire:navigate class="group block w-full px-4 py-3 bg-gradient-to-r from-highlight to-highlight/90 text-white text-center font-semibold rounded-lg hover:from-highlight/90 hover:to-highlight transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                    <div class="flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span>Make Picks</span>
                    </div>
                </a>
                <a href="{{ route('leaderboard') }}" wire:navigate class="group block w-full px-4 py-3 bg-gradient-to-r from-primary/10 to-primary/5 text-primary text-center font-semibold rounded-lg hover:from-primary/20 hover:to-primary/10 transition-all duration-300 border border-primary/20 hover:border-primary/30 transform hover:-translate-y-0.5">
                    <div class="flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <span>View Leaderboard</span>
                    </div>
                </a>
            </div>
        </div>
    </div>

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Upcoming Games --}}
        <div class="lg:col-span-2 bg-gradient-to-br from-card to-soft/20 rounded-xl shadow-lg border border-primary/5 p-6 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-10 h-10 bg-gradient-to-br from-primary to-primary/80 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-primary">Upcoming Games</h2>
            </div>
            @if($upcomingGames->count() > 0)
                <div class="divide-y divide-primary/10">
                    @foreach($upcomingGames as $game)
                        <div class="group py-6 first:pt-0 last:pb-0 transition-all duration-300">
                            {{-- Date and Time Row --}}
                            <div class="flex items-center justify-center mb-4">
                                <div class="flex items-center space-x-3 bg-primary/5 px-4 py-2 rounded-full">
                                    <svg class="w-4 h-4 text-primary/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-sm font-semibold text-primary">{{ Carbon\Carbon::parse($game['date_time'])->format('D, M j') }}</span>
                                    <span class="text-primary/40">•</span>
                                    <span class="text-sm text-primary/70">{{ Carbon\Carbon::parse($game['date_time'])->setTimezone('America/Chicago')->format('g:i A T') }}</span>
                                </div>
                            </div>

                            {{-- Teams Row --}}
                            <div class="grid grid-cols-3 gap-4 items-center px-4">
                                {{-- Away Team --}}
                                <div class="flex items-center justify-end space-x-3">
                                    @if($game['away_team']?->logo_url)
                                        <img src="{{ $game['away_team']->logo_url }}"
                                             alt="{{ $game['away_team']->name }}"
                                             class="w-16 h-16">
                                    @else
                                        <div class="w-16 h-16 bg-primary/20 rounded-full flex items-center justify-center">
                                            <span class="text-primary text-lg font-bold">?</span>
                                        </div>
                                    @endif
                                    <div class="text-center">
                                        <span class="font-bold text-primary text-lg block">{{ $game['away_team']?->abbreviation ?? 'TBD' }}</span>
                                        <span class="text-xs text-primary/60">Away</span>
                                    </div>
                                </div>

                                {{-- VS Separator --}}
                                <div class="flex flex-col items-center justify-center space-y-1">
                                    <div class="text-primary/40 font-bold text-xl">VS</div>
                                    <div class="w-8 h-px bg-primary/20"></div>
                                </div>

                                {{-- Home Team --}}
                                <div class="flex items-center justify-start space-x-3">
                                    <div class="text-center">
                                        <span class="font-bold text-primary text-lg block">{{ $game['home_team']?->abbreviation ?? 'TBD' }}</span>
                                        <span class="text-xs text-primary/60">Home</span>
                                    </div>
                                    @if($game['home_team']?->logo_url)
                                        <img src="{{ $game['home_team']->logo_url }}"
                                             alt="{{ $game['home_team']->name }}"
                                             class="w-16 h-16">
                                    @else
                                        <div class="w-16 h-16 bg-primary/20 rounded-full flex items-center justify-center">
                                            <span class="text-primary text-lg font-bold">?</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <p class="text-primary/60">No upcoming games this week</p>
                </div>
            @endif
        </div>

        {{-- Top 5 Leaderboard --}}
        <div class="bg-gradient-to-br from-card to-soft/20 rounded-xl shadow-lg border border-primary/5 p-6 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-primary">Top Players</h2>
                </div>
                <a href="{{ route('leaderboard') }}" wire:navigate class="text-sm text-highlight hover:text-highlight/80 font-semibold px-3 py-1 rounded-full bg-highlight/10 hover:bg-highlight/20 transition-colors">
                    View all →
                </a>
            </div>
            @if($leaderboardPreview->count() > 0)
                <div class="space-y-3">
                    @foreach($leaderboardPreview as $player)
                        <div class="flex items-center justify-between p-3 rounded-xl transition-all duration-300 {{ $loop->first ? 'bg-gradient-to-r from-yellow-50 to-orange-50 border border-yellow-200' : 'bg-soft/20 hover:bg-soft/30 border border-transparent hover:border-primary/10' }}">
                            <div class="flex items-center space-x-4">
                                <div class="relative">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm
                                        {{ $loop->first ? 'bg-gradient-to-r from-yellow-400 to-orange-500 text-white' : 'bg-primary/10 text-primary/70' }}">
                                        {{ $player['rank'] }}
                                    </div>
                                    @if($loop->first)
                                        <div class="absolute -top-1 -right-1 w-3 h-3 bg-yellow-400 rounded-full animate-pulse"></div>
                                    @endif
                                </div>
                                <div>
                                    <span class="font-semibold text-primary {{ $loop->first ? 'text-lg' : '' }}">{{ $player['user_name'] }}</span>
                                    @if($loop->first)
                                        <div class="text-xs text-orange-600 font-medium">👑 Leader</div>
                                    @endif
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-sm font-semibold {{ $loop->first ? 'text-orange-600' : 'text-primary/60' }}">
                                    {{ $player['wins'] }}-{{ $player['losses'] }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-primary/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <p class="text-primary/60">No rankings available yet</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Recent Scores --}}
    <div class="bg-gradient-to-br from-card to-soft/20 rounded-xl shadow-lg border border-primary/5 p-6 hover:shadow-xl transition-shadow duration-300">
        <div class="flex items-center space-x-3 mb-6">
            <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
            </div>
            <h2 class="text-xl font-bold text-primary">Recent Final Scores</h2>
        </div>
        @if($recentScores->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($recentScores as $score)
                    <div class="group p-5 bg-gradient-to-br from-soft/30 to-soft/10 rounded-xl border border-primary/5 hover:border-primary/20 hover:shadow-md transition-all duration-300 hover:scale-105">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-xs font-semibold text-primary/70 bg-primary/10 px-2 py-1 rounded-full">Week {{ $score['week'] }}</span>
                            <span class="text-xs text-primary/60">{{ Carbon\Carbon::parse($score['date_time'])->format('M j') }}</span>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-2 rounded-lg transition-colors duration-200 {{ $score['away_score'] > $score['home_score'] ? 'bg-green-50 border-l-4 border-green-500 font-bold' : 'hover:bg-primary/5' }}">
                                <div class="flex items-center space-x-3">
                                    @if($score['away_team']?->logo_url)
                                        <img src="{{ $score['away_team']->logo_url }}" alt="{{ $score['away_team']->name }}" class="w-8 h-8 rounded-full shadow-sm">
                                    @else
                                        <div class="w-8 h-8 bg-primary/20 rounded-full flex items-center justify-center">
                                            <span class="text-primary text-xs font-bold">?</span>
                                        </div>
                                    @endif
                                    <span class="text-sm font-semibold text-primary">{{ $score['away_team']?->abbreviation ?? 'TBD' }}</span>
                                </div>
                                <span class="text-lg font-bold {{ $score['away_score'] > $score['home_score'] ? 'text-green-600' : 'text-primary' }}">{{ $score['away_score'] }}</span>
                            </div>
                            <div class="flex items-center justify-between p-2 rounded-lg transition-colors duration-200 {{ $score['home_score'] > $score['away_score'] ? 'bg-green-50 border-l-4 border-green-500 font-bold' : 'hover:bg-primary/5' }}">
                                <div class="flex items-center space-x-3">
                                    @if($score['home_team']?->logo_url)
                                        <img src="{{ $score['home_team']->logo_url }}" alt="{{ $score['home_team']->name }}" class="w-8 h-8 rounded-full shadow-sm">
                                    @else
                                        <div class="w-8 h-8 bg-primary/20 rounded-full flex items-center justify-center">
                                            <span class="text-primary text-xs font-bold">?</span>
                                        </div>
                                    @endif
                                    <span class="text-sm font-semibold text-primary">{{ $score['home_team']?->abbreviation ?? 'TBD' }}</span>
                                </div>
                                <span class="text-lg font-bold {{ $score['home_score'] > $score['away_score'] ? 'text-green-600' : 'text-primary' }}">{{ $score['home_score'] }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                </div>
                <p class="text-primary/60">No completed games yet this season</p>
            </div>
        @endif
    </div>
</div>
