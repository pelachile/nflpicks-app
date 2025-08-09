<?php

use App\Livewire\CreateGroup;
use App\Livewire\Dashboard;
use App\Livewire\Groups;
use App\Livewire\JoinGroup;
use App\Livewire\ManageGroup;
use App\Livewire\ShowGroup;
use App\Livewire\GamePredictions;
use App\Livewire\WeeklyLeaderboard;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Welcome\WelcomePage;
use Illuminate\Support\Facades\Route;

Route::get('/', action: WelcomePage::class)->name('welcome');

Route::get('dashboard', Dashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::middleware(['auth'])->group(function () {
        Route::get('/predictions', GamePredictions::class)->name('predictions');
        Route::get('/leaderboard', WeeklyLeaderboard::class)->name('leaderboard');
        Route::get('/groups', Groups::class)->name('groups.index');
        Route::get('/groups/create', CreateGroup::class)->name('groups.create');
        Route::get('/groups/join', JoinGroup::class)->name('groups.join');
        Route::get('/groups/{group}', ShowGroup::class)->name('groups.show');
        Route::get('/groups/{group}/manage', ManageGroup::class)->name('groups.manage');
    });

});

require __DIR__.'/auth.php';
