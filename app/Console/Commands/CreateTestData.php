<?php

namespace App\Console\Commands;

use App\Models\Game;
use App\Models\User;
use App\Models\UserPrediction;
use Illuminate\Console\Command;

class CreateTestData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:test-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create test users and predictions for week 10 2024';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Delete existing test users
        User::where('email', 'like', '%@test.com')->delete();

        // Create test users
        $users = [];
        $users[] = User::create([
            'name' => 'Test User 1',
            'email' => 'user1@test.com',
            'password' => bcrypt('password')
        ]);
        $users[] = User::create([
            'name' => 'Test User 2', 
            'email' => 'user2@test.com',
            'password' => bcrypt('password')
        ]);

        $this->info('Created 2 test users');

        $games = Game::with('gameTeams.team')->where('week', 10)->where('season', 2024)->get();
        
        if ($games->count() === 0) {
            $this->error('No games found for week 10, 2024');
            return 1;
        }

        $mondayGame = $games->filter(fn($game) => $game->isTiebreakerGame())->first();

        $this->info('Monday game total score: ' . $mondayGame?->getTotalScore());

        // Create predictions for each user
        foreach ($users as $userIndex => $user) {
            $this->line('');
            $this->info('Creating predictions for ' . $user->name . ':');
            
            $correctPicks = 0;
            
            foreach ($games as $gameIndex => $game) {
                $homeTeam = $game->gameTeams->where('is_home', true)->first();
                $awayTeam = $game->gameTeams->where('is_home', false)->first();
                
                // Determine actual winner
                $actualWinner = $homeTeam->score > $awayTeam->score ? $homeTeam->team : $awayTeam->team;
                
                // User 1 gets 3/4 correct, User 2 gets 3/4 correct (different games)
                $shouldPickCorrectly = ($userIndex === 0 && $gameIndex !== 1) || ($userIndex === 1 && $gameIndex !== 2);
                
                $predictedTeam = $shouldPickCorrectly ? $actualWinner : ($actualWinner === $homeTeam->team ? $awayTeam->team : $homeTeam->team);
                
                if ($shouldPickCorrectly) $correctPicks++;
                
                // Add tiebreaker for Monday game
                $tiebreakerPrediction = null;
                if ($game->isTiebreakerGame() && $mondayGame) {
                    $actualTotal = $mondayGame->getTotalScore();
                    // User 1 predicts closer to actual, User 2 predicts further
                    $tiebreakerPrediction = $userIndex === 0 ? $actualTotal - 3 : $actualTotal - 15;
                }
                
                UserPrediction::create([
                    'user_id' => $user->id,
                    'game_id' => $game->id,
                    'predicted_team_id' => $predictedTeam->id,
                    'tiebreaker_prediction' => $tiebreakerPrediction
                ]);
                
                $isCorrect = $predictedTeam === $actualWinner ? '✓' : '✗';
                $tiebreakerText = $tiebreakerPrediction ? ' (TB: ' . $tiebreakerPrediction . ')' : '';
                $this->line('  ' . $isCorrect . ' Predicted ' . $predictedTeam->abbreviation . $tiebreakerText);
            }
            
            $this->info('Total correct: ' . $correctPicks . '/4');
        }

        $this->info('');
        $this->info('✅ Test data created successfully!');
        $this->info('Now run: php artisan scores:calculate 10 2024');

        return 0;
    }
}
