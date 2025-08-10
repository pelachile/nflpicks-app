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
        // Always use CDT timezone for consistency
        $now = \Carbon\Carbon::now('America/Chicago');
        
        \Log::info('Schedule check', [
            'time' => $now->format('Y-m-d H:i:s T'),
            'day' => $now->format('l'),
            'hour' => $now->hour,
            'is_saturday' => $now->isSaturday(),
            'is_sunday' => $now->isSunday(),
            'is_monday' => $now->isMonday(),
            'is_thursday' => $now->isThursday(),
        ]);
        
        // Saturday: 12 PM - 12 AM CDT
        if ($now->isSaturday() && $now->hour >= 12 && $now->hour <= 23) {
            \Log::info('Schedule: Running on Saturday', ['hour' => $now->hour]);
            return true;
        }
        
        // Sunday: 12 PM - 12 AM CDT
        if ($now->isSunday() && $now->hour >= 12 && $now->hour <= 23) {
            \Log::info('Schedule: Running on Sunday', ['hour' => $now->hour]);
            return true;
        }
        
        // Monday: 7 PM - 12 AM CDT
        if ($now->isMonday() && $now->hour >= 19 && $now->hour <= 23) {
            \Log::info('Schedule: Running on Monday', ['hour' => $now->hour]);
            return true;
        }
        
        // Thursday: 7 PM - 12 AM CDT
        if ($now->isThursday() && $now->hour >= 19 && $now->hour <= 23) {
            \Log::info('Schedule: Running on Thursday', ['hour' => $now->hour]);
            return true;
        }
        
        \Log::info('Schedule: Not running - outside game hours');
        return false;
    })
    ->withoutOverlapping();
