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

// Automatically fetch live scores for current week/season type during game times (CDT)
// Thursday: 7 PM - 12 AM CDT
Schedule::command('fetch:current-week-scores')
    ->thursdays()
    ->between('19:00', '23:59')
    ->hourly()
    ->timezone('America/Chicago')
    ->withoutOverlapping();

// Sunday: 12 PM - 12 AM CDT  
Schedule::command('fetch:current-week-scores')
    ->sundays()
    ->between('12:00', '23:59')
    ->hourly()
    ->timezone('America/Chicago')
    ->withoutOverlapping();

// Monday: 7 PM - 12 AM CDT (includes weekly scoring calculation)
Schedule::command('fetch:current-week-scores')
    ->mondays()
    ->between('19:00', '23:59')
    ->hourly()
    ->timezone('America/Chicago')
    ->withoutOverlapping();
