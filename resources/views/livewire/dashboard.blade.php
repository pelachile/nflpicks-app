<div class="max-w-7xl mx-auto p-6 space-y-6">
    {{-- Header --}}
    <div class="bg-card rounded-lg shadow-md p-6">
        <h1 class="text-3xl font-bold text-primary mb-2">Dashboard</h1>
        <p class="text-primary/60">{{ $currentSeasonTypeName }} Week {{ $currentWeek }}, 2025</p>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- This Week's Predictions --}}
        <div class="bg-card rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-medium text-primary/60">This Week's Picks</h3>
                <svg class="w-5 h-5 text-highlight" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.398.815 1.027 1.398 1.8 1.398h.174c.08 0 .157-.031.22-.067.075-.043.158-.097.234-.157.1-.075.206-.15.309-.224.296-.216.514-.467.691-.748a3.468 3.468 0 0 0 .422-.92c.17-.548.267-1.126.267-1.726v-.51H5.904Z" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-primary">
                @if($userStats['total_games_this_week'] > 0)
                    {{ $userStats['predictions_this_week'] }} / {{ $userStats['total_games_this_week'] }}
                @else
                    --
                @endif
            </p>
            <p class="text-sm text-primary/60 mt-1">Games picked</p>
        </div>

        {{-- Season Record --}}
        <div class="bg-card rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-medium text-primary/60">Season Record</h3>
                <svg class="w-5 h-5 text-highlight" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-primary">
                @if($userStats['season_total'] > 0)
                    {{ $userStats['season_correct'] }}-{{ $userStats['season_total'] - $userStats['season_correct'] }}
                @else
                    --
                @endif
            </p>
            <p class="text-sm text-primary/60 mt-1">{{ $userStats['season_percentage'] }}% correct</p>
        </div>

        {{-- Latest Week Rank --}}
        <div class="bg-card rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-medium text-primary/60">Latest Rank</h3>
                <svg class="w-5 h-5 text-highlight" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 0 0 2.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.228a25.628 25.628 0 0 1 2.916.52 6.003 6.003 0 0 1-5.395 4.972m0 0a6.726 6.726 0 0 1-2.749 1.35m0 0a6.772 6.772 0 0 1-3.044 0" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-primary">
                @if($userStats['latest_week_rank'])
                    #{{ $userStats['latest_week_rank'] }}
                @else
                    --
                @endif
            </p>
            <p class="text-sm text-primary/60 mt-1">
                @if($userStats['latest_week_record'])
                    Record: {{ $userStats['latest_week_record'] }}
                @else
                    No rankings yet
                @endif
            </p>
        </div>

        {{-- Quick Actions --}}
        <div class="bg-card rounded-lg shadow-md p-6">
            <h3 class="text-sm font-medium text-primary/60 mb-4">Quick Actions</h3>
            <div class="space-y-2">
                <a href="{{ route('predictions') }}" wire:navigate class="block w-full px-4 py-2 bg-highlight text-primary text-center font-medium rounded-md hover:bg-highlight/90 transition-colors">
                    Make Picks
                </a>
                <a href="{{ route('leaderboard') }}" wire:navigate class="block w-full px-4 py-2 bg-primary/10 text-primary text-center font-medium rounded-md hover:bg-primary/20 transition-colors">
                    View Leaderboard
                </a>
            </div>
        </div>
    </div>

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Upcoming Games --}}
        <div class="lg:col-span-2 bg-card rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-primary mb-4">Upcoming Games</h2>
            @if($upcomingGames->count() > 0)
                <div class="space-y-3">
                    @foreach($upcomingGames as $game)
                        <div class="flex items-center justify-between p-3 bg-soft/10 rounded-lg">
                            <div class="flex items-center space-x-4">
                                {{-- Away Team --}}
                                <div class="flex items-center space-x-2">
                                    @if($game['away_team']?->logo_url)
                                        <img src="{{ $game['away_team']->logo_url }}" alt="{{ $game['away_team']->name }}" class="w-8 h-8">
                                    @endif
                                    <span class="font-medium text-primary">{{ $game['away_team']?->abbreviation ?? 'TBD' }}</span>
                                </div>
                                
                                <span class="text-primary/40">@</span>
                                
                                {{-- Home Team --}}
                                <div class="flex items-center space-x-2">
                                    @if($game['home_team']?->logo_url)
                                        <img src="{{ $game['home_team']->logo_url }}" alt="{{ $game['home_team']->name }}" class="w-8 h-8">
                                    @endif
                                    <span class="font-medium text-primary">{{ $game['home_team']?->abbreviation ?? 'TBD' }}</span>
                                </div>
                            </div>
                            
                            <div class="text-right">
                                <p class="text-sm font-medium text-primary">{{ Carbon\Carbon::parse($game['date_time'])->format('D, M j') }}</p>
                                <p class="text-xs text-primary/60">{{ Carbon\Carbon::parse($game['date_time'])->setTimezone('America/Chicago')->format('g:i A T') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-primary/60">No upcoming games this week</p>
            @endif
        </div>

        {{-- Top 5 Leaderboard --}}
        <div class="bg-card rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-primary">Top Players</h2>
                <a href="{{ route('leaderboard') }}" wire:navigate class="text-sm text-highlight hover:text-highlight/80">
                    View all →
                </a>
            </div>
            @if($leaderboardPreview->count() > 0)
                <div class="space-y-2">
                    @foreach($leaderboardPreview as $player)
                        <div class="flex items-center justify-between p-2 rounded {{ $loop->first ? 'bg-highlight/10' : '' }}">
                            <div class="flex items-center space-x-3">
                                <span class="text-lg font-bold {{ $loop->first ? 'text-highlight' : 'text-primary/60' }}">
                                    {{ $player['rank'] }}
                                </span>
                                <span class="font-medium text-primary">{{ $player['user_name'] }}</span>
                            </div>
                            <span class="text-sm text-primary/60">{{ $player['wins'] }}-{{ $player['losses'] }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-primary/60">No rankings available yet</p>
            @endif
        </div>
    </div>

    {{-- Recent Scores --}}
    <div class="bg-card rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-primary mb-4">Recent Final Scores</h2>
        @if($recentScores->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($recentScores as $score)
                    <div class="p-4 bg-soft/10 rounded-lg">
                        <div class="flex justify-between items-start mb-2">
                            <div class="text-xs text-primary/60">Week {{ $score['week'] }}</div>
                            <div class="text-xs text-primary/60">{{ Carbon\Carbon::parse($score['date_time'])->format('M j') }}</div>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between {{ $score['away_score'] > $score['home_score'] ? 'font-bold' : '' }}">
                                <div class="flex items-center space-x-2">
                                    @if($score['away_team']?->logo_url)
                                        <img src="{{ $score['away_team']->logo_url }}" alt="{{ $score['away_team']->name }}" class="w-6 h-6">
                                    @endif
                                    <span class="text-sm text-primary">{{ $score['away_team']?->abbreviation ?? 'TBD' }}</span>
                                </div>
                                <span class="text-sm text-primary">{{ $score['away_score'] }}</span>
                            </div>
                            <div class="flex items-center justify-between {{ $score['home_score'] > $score['away_score'] ? 'font-bold' : '' }}">
                                <div class="flex items-center space-x-2">
                                    @if($score['home_team']?->logo_url)
                                        <img src="{{ $score['home_team']->logo_url }}" alt="{{ $score['home_team']->name }}" class="w-6 h-6">
                                    @endif
                                    <span class="text-sm text-primary">{{ $score['home_team']?->abbreviation ?? 'TBD' }}</span>
                                </div>
                                <span class="text-sm text-primary">{{ $score['home_score'] }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-primary/60">No completed games yet this season</p>
        @endif
    </div>
</div>