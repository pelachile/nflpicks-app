<div class="max-w-6xl mx-auto p-6">
    <div class="bg-card rounded-lg shadow-md p-6 mb-6">
        <h1 class="text-3xl font-bold text-primary mb-4">
            🏆 Weekly Leaderboard
        </h1>
        
        {{-- Week/Season Selector --}}
        <div class="flex space-x-4 mb-6">
            <div>
                <label class="block text-sm font-medium text-primary mb-2">Week</label>
                <select wire:model.live="selectedWeek" class="px-3 py-2 border border-primary/20 rounded-md shadow-sm focus:ring-highlight focus:border-highlight">
                    @for($week = 1; $week <= 18; $week++)
                        <option value="{{ $week }}">Week {{ $week }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-primary mb-2">Season</label>
                <select wire:model.live="selectedSeason" class="px-3 py-2 border border-primary/20 rounded-md shadow-sm focus:ring-highlight focus:border-highlight">
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Leaderboard --}}
    <div class="bg-card rounded-lg shadow-md overflow-hidden">
        @if(empty($weeklyScores))
            <div class="p-8 text-center">
                <p class="text-primary/60">No scores calculated for Week {{ $selectedWeek }}, {{ $selectedSeason }} season.</p>
                <p class="text-sm text-primary/40 mt-2">Scores are calculated after all games in the week are completed.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-primary/5">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-primary/70 uppercase tracking-wider">Rank</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-primary/70 uppercase tracking-wider">Player</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-primary/70 uppercase tracking-wider">Record</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-primary/70 uppercase tracking-wider">Tiebreaker</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-primary/70 uppercase tracking-wider">Actual</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-primary/70 uppercase tracking-wider">Difference</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-primary/10">
                        @foreach($weeklyScores as $score)
                            <tr class="hover:bg-soft/30 transition-colors {{ $score['rank'] <= 3 ? 'bg-highlight/5' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="text-2xl mr-2">
                                            @if($score['rank'] === 1) 🥇
                                            @elseif($score['rank'] === 2) 🥈
                                            @elseif($score['rank'] === 3) 🥉
                                            @else {{ $score['rank'] }}
                                            @endif
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-primary">{{ $score['user_name'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-lg font-bold text-primary">{{ $score['record'] }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($score['had_tiebreaker'])
                                        <span class="text-sm text-primary">{{ $score['tiebreaker_prediction'] }}</span>
                                    @else
                                        <span class="text-sm text-primary/40">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($score['actual_tiebreaker_score'])
                                        <span class="text-sm text-primary">{{ $score['actual_tiebreaker_score'] }}</span>
                                    @else
                                        <span class="text-sm text-primary/40">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($score['had_tiebreaker'] && $score['actual_tiebreaker_score'])
                                        <span class="text-sm {{ $score['tiebreaker_difference'] <= 3 ? 'text-green-600' : ($score['tiebreaker_difference'] <= 7 ? 'text-highlight' : 'text-primary') }}">
                                            {{ $score['tiebreaker_difference'] }}
                                        </span>
                                    @else
                                        <span class="text-sm text-primary/40">N/A</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{-- Legend --}}
            <div class="p-4 bg-primary/5 border-t border-primary/10">
                <p class="text-xs text-primary/60">
                    <strong>Tiebreaker:</strong> When users have the same number of wins, the winner is determined by who came closest to predicting the total score of Monday Night Football.
                </p>
            </div>
        @endif
    </div>
</div>
