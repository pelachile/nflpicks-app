<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Log;

// TEMPORARY: Simple scheduler test that runs every minute
Schedule::call(function () {
    Log::info('Scheduler heartbeat', [
        'timestamp' => now()->toISOString(),
        'message' => 'Scheduler is running'
    ]);
})->everyMinute()->name('scheduler-heartbeat');

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

// TEMPORARY: Run fetch:live-scores every 15 minutes without time restrictions for testing
Schedule::command('fetch:live-scores')
    ->everyFifteenMinutes()
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
