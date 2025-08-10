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

// Fetch live scores during NFL game times (CDT)
Schedule::command('fetch:live-scores')
    ->everyFifteenMinutes()
    ->when(function () {
        $now = \Carbon\Carbon::now('America/Chicago');
        
        // Saturday: 12 PM - 12 AM CDT
        if ($now->isSaturday() && $now->hour >= 12 && $now->hour <= 23) {
            return true;
        }
        
        // Sunday: 12 PM - 12 AM CDT
        if ($now->isSunday() && $now->hour >= 12 && $now->hour <= 23) {
            return true;
        }
        
        // Monday: 7 PM - 12 AM CDT
        if ($now->isMonday() && $now->hour >= 19 && $now->hour <= 23) {
            return true;
        }
        
        // Thursday: 7 PM - 12 AM CDT
        if ($now->isThursday() && $now->hour >= 19 && $now->hour <= 23) {
            return true;
        }
        
        return false;
    })
    ->withoutOverlapping();
