<?php

namespace App\Console\Commands;

use App\Models\WeeklyScore;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DebugRouteErrors extends Command
{
    protected $signature = 'debug:routes';
    protected $description = 'Debug dashboard and leaderboard route errors';

    public function handle()
    {
        $this->info('Debugging Route Errors...');
        
        // Check database connection
        try {
            DB::connection()->getPdo();
            $this->info("✓ Database connection successful");
        } catch (\Exception $e) {
            $this->error("✗ Database connection failed: " . $e->getMessage());
            return 1;
        }
        
        // Check tables exist
        $requiredTables = ['users', 'games', 'teams', 'user_predictions', 'weekly_scores', 'game_teams'];
        foreach ($requiredTables as $table) {
            if (Schema::hasTable($table)) {
                $this->info("✓ Table '{$table}' exists");
            } else {
                $this->error("✗ Table '{$table}' MISSING");
            }
        }
        
        // Check weekly_scores columns
        if (Schema::hasTable('weekly_scores')) {
            $this->info("\nweekly_scores columns:");
            $columns = Schema::getColumnListing('weekly_scores');
            foreach ($columns as $column) {
                $this->info("  - {$column}");
            }
            
            if (!in_array('season_type', $columns)) {
                $this->warn("  ⚠ Missing 'season_type' column!");
            }
        }
        
        // Test WeeklyScore model
        $this->info("\nTesting WeeklyScore model:");
        try {
            $count = WeeklyScore::count();
            $this->info("  WeeklyScore count: {$count}");
            
            // Test with user relationship
            $scoreWithUser = WeeklyScore::with('user')->first();
            if ($scoreWithUser) {
                $this->info("  First score belongs to: " . ($scoreWithUser->user ? $scoreWithUser->user->name : 'NO USER'));
            }
        } catch (\Exception $e) {
            $this->error("  Error accessing WeeklyScore: " . $e->getMessage());
        }
        
        // Check fillable properties
        $this->info("\nWeeklyScore fillable properties:");
        $model = new \App\Models\WeeklyScore();
        foreach ($model->getFillable() as $field) {
            $this->info("  - {$field}");
        }
        
        // Test date/time logic
        $this->info("\nDate/Time Logic:");
        $this->info("  Server timezone: " . config('app.timezone'));
        $this->info("  Current time: " . Carbon::now());
        $this->info("  PHP timezone: " . date_default_timezone_get());
        
        // Check for any error logs
        $this->info("\nChecking Laravel logs...");
        $logFile = storage_path('logs/laravel.log');
        if (file_exists($logFile)) {
            $lines = file($logFile);
            $recentErrors = array_slice($lines, -20);
            
            $foundError = false;
            foreach ($recentErrors as $line) {
                if (stripos($line, 'dashboard') !== false || stripos($line, 'leaderboard') !== false) {
                    $this->error("Recent error: " . trim($line));
                    $foundError = true;
                }
            }
            
            if (!$foundError) {
                $this->info("  No recent dashboard/leaderboard errors in log");
            }
        }
        
        return 0;
    }
}