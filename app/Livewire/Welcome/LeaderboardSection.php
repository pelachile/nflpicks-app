<?php

namespace App\Livewire\Welcome;

use Livewire\Component;

class LeaderboardSection extends Component
{
    public $sampleLeaders = [
        ['name' => 'Sarah', 'record' => '12–2', 'emoji' => '🥇'],
        ['name' => 'Mike', 'record' => '11–3', 'emoji' => '🔥'],
        ['name' => 'Alex', 'record' => '10–4', 'emoji' => '💪'],
    ];

    public function render()
    {
        return view('livewire.welcome.leaderboard-section');
    }
}
