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
// Saturday: 12 PM - 12 AM CDT (every 15 minutes)
Schedule::command('fetch:live-scores')
    ->saturdays()
    ->between('12:00', '23:59')
    ->everyFifteenMinutes()
    ->timezone('America/Chicago')
    ->withoutOverlapping();

// Sunday: 12 PM - 12 AM CDT (every 15 minutes)
Schedule::command('fetch:live-scores')
    ->sundays()
    ->between('12:00', '23:59')
    ->everyFifteenMinutes()
    ->timezone('America/Chicago')
    ->withoutOverlapping();

// Monday: 7 PM - 12 AM CDT (every 15 minutes)
Schedule::command('fetch:live-scores')
    ->mondays()
    ->between('19:00', '23:59')
    ->everyFifteenMinutes()
    ->timezone('America/Chicago')
    ->withoutOverlapping();

// Thursday: 7 PM - 12 AM CDT (every 15 minutes)
Schedule::command('fetch:live-scores')
    ->thursdays()
    ->between('19:00', '23:59')
    ->everyFifteenMinutes()
    ->timezone('America/Chicago')
    ->withoutOverlapping();
