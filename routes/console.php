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
        // Get server time and CDT time for comparison
        $serverTime = \Carbon\Carbon::now();
        $cdtTime = \Carbon\Carbon::now('America/Chicago');
        
        \Log::info('Schedule check', [
            'server_time' => $serverTime->format('Y-m-d H:i:s T'),
            'cdt_time' => $cdtTime->format('Y-m-d H:i:s T'),
            'cdt_day' => $cdtTime->format('l'),
            'cdt_hour' => $cdtTime->hour,
            'is_saturday' => $cdtTime->isSaturday(),
            'is_sunday' => $cdtTime->isSunday(),
            'is_monday' => $cdtTime->isMonday(),
            'is_thursday' => $cdtTime->isThursday(),
        ]);
        
        // Use CDT time for all checks
        $now = $cdtTime;
        
        // Saturday: 12 PM - 12 AM CDT (1 PM - 1 AM EDT)
        if ($now->isSaturday() && $now->hour >= 12 && $now->hour <= 23) {
            \Log::info('Schedule: Running on Saturday CDT', ['cdt_hour' => $now->hour]);
            return true;
        }
        
        // Sunday: 12 PM - 12 AM CDT (1 PM - 1 AM EDT)
        if ($now->isSunday() && $now->hour >= 12 && $now->hour <= 23) {
            \Log::info('Schedule: Running on Sunday CDT', ['cdt_hour' => $now->hour]);
            return true;
        }
        
        // Monday: 7 PM - 12 AM CDT (8 PM - 1 AM EDT)
        if ($now->isMonday() && $now->hour >= 19 && $now->hour <= 23) {
            \Log::info('Schedule: Running on Monday CDT', ['cdt_hour' => $now->hour]);
            return true;
        }
        
        // Thursday: 7 PM - 12 AM CDT (8 PM - 1 AM EDT)  
        if ($now->isThursday() && $now->hour >= 19 && $now->hour <= 23) {
            \Log::info('Schedule: Running on Thursday CDT', ['cdt_hour' => $now->hour]);
            return true;
        }
        
        // FALLBACK: Also check server local time in case timezone conversion fails
        // Saturday: 1 PM - 1 AM EDT
        if ($serverTime->isSaturday() && $serverTime->hour >= 13 && ($serverTime->hour <= 23 || $serverTime->hour == 0)) {
            \Log::info('Schedule: Running on Saturday EDT fallback', ['edt_hour' => $serverTime->hour]);
            return true;
        }
        
        // Sunday: 1 PM - 1 AM EDT
        if ($serverTime->isSunday() && $serverTime->hour >= 13 && ($serverTime->hour <= 23 || $serverTime->hour == 0)) {
            \Log::info('Schedule: Running on Sunday EDT fallback', ['edt_hour' => $serverTime->hour]);
            return true;
        }
        
        // Monday: 8 PM - 1 AM EDT
        if ($serverTime->isMonday() && $serverTime->hour >= 20 && ($serverTime->hour <= 23 || $serverTime->hour == 0)) {
            \Log::info('Schedule: Running on Monday EDT fallback', ['edt_hour' => $serverTime->hour]);
            return true;
        }
        
        // Thursday: 8 PM - 1 AM EDT
        if ($serverTime->isThursday() && $serverTime->hour >= 20 && ($serverTime->hour <= 23 || $serverTime->hour == 0)) {
            \Log::info('Schedule: Running on Thursday EDT fallback', ['edt_hour' => $serverTime->hour]);
            return true;
        }
        
        \Log::info('Schedule: Not running - outside game hours');
        return false;
    })
    ->withoutOverlapping();
