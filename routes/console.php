<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Process queued jobs only when needed - after team data is dispatched
Schedule::command('queue:work --stop-when-empty --max-time=300')
    ->weeklyOn(2, '02:05') // 5 minutes after team data is dispatched
    ->withoutOverlapping();

// Retry failed jobs once weekly
Schedule::command('queue:retry all')
    ->weeklyOn(2, '02:10') // 10 minutes after team data is dispatched
    ->withoutOverlapping();

// Fetch team data every Tuesday at 2 AM
Schedule::command('fetch:team-data')
    ->weeklyOn(2, '02:00') // Tuesday at 2 AM
    ->withoutOverlapping();

// Fetch live scores during game times with comprehensive logging
Schedule::command('fetch:live-scores')
    ->everyFifteenMinutes()
    ->when(function () {
        // Convert server time (UTC) to Eastern Time for NFL game scheduling
        $easternTime = \Carbon\Carbon::now('America/New_York');
        
        // Saturday games: 12 PM to 11:59 PM Eastern
        if ($easternTime->isSaturday() && $easternTime->hour >= 12 && $easternTime->hour <= 23) {
            return true;
        }
        
        // Sunday games: 12 PM to 11:59 PM Eastern
        if ($easternTime->isSunday() && $easternTime->hour >= 12 && $easternTime->hour <= 23) {
            return true;
        }
        
        // Monday games: 7 PM to 11:59 PM Eastern
        if ($easternTime->isMonday() && $easternTime->hour >= 19 && $easternTime->hour <= 23) {
            return true;
        }
        
        // Thursday games: 7 PM to 11:59 PM Eastern
        if ($easternTime->isThursday() && $easternTime->hour >= 19 && $easternTime->hour <= 23) {
            return true;
        }
        
        return false;
    })
    ->withoutOverlapping()
    ->before(function () {
        $easternTime = \Carbon\Carbon::now('America/New_York');
        \Illuminate\Support\Facades\Log::info('Scheduler: About to run fetch:live-scores', [
            'utc_timestamp' => now()->toISOString(),
            'eastern_timestamp' => $easternTime->toISOString(),
            'eastern_time' => $easternTime->format('l, M j - g:i A T'),
            'server_timezone' => config('app.timezone')
        ]);
    })
    ->after(function () {
        \Illuminate\Support\Facades\Log::info('Scheduler: Completed fetch:live-scores', [
            'timestamp' => now()->toISOString()
        ]);
    });
