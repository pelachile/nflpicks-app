<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Team;

return new class extends Migration
{
    public function up(): void
    {
        $teamData = [
            // AFC East
            ['abbreviation' => 'BUF', 'conference' => 'AFC', 'division' => 'East'],
            ['abbreviation' => 'MIA', 'conference' => 'AFC', 'division' => 'East'],
            ['abbreviation' => 'NE', 'conference' => 'AFC', 'division' => 'East'],
            ['abbreviation' => 'NYJ', 'conference' => 'AFC', 'division' => 'East'],

            // AFC North
            ['abbreviation' => 'BAL', 'conference' => 'AFC', 'division' => 'North'],
            ['abbreviation' => 'CIN', 'conference' => 'AFC', 'division' => 'North'],
            ['abbreviation' => 'CLE', 'conference' => 'AFC', 'division' => 'North'],
            ['abbreviation' => 'PIT', 'conference' => 'AFC', 'division' => 'North'],

            // AFC South
            ['abbreviation' => 'HOU', 'conference' => 'AFC', 'division' => 'South'],
            ['abbreviation' => 'IND', 'conference' => 'AFC', 'division' => 'South'],
            ['abbreviation' => 'JAX', 'conference' => 'AFC', 'division' => 'South'],
            ['abbreviation' => 'TEN', 'conference' => 'AFC', 'division' => 'South'],

            // AFC West
            ['abbreviation' => 'DEN', 'conference' => 'AFC', 'division' => 'West'],
            ['abbreviation' => 'KC', 'conference' => 'AFC', 'division' => 'West'],
            ['abbreviation' => 'LV', 'conference' => 'AFC', 'division' => 'West'],
            ['abbreviation' => 'LAC', 'conference' => 'AFC', 'division' => 'West'],

            // NFC East
            ['abbreviation' => 'DAL', 'conference' => 'NFC', 'division' => 'East'],
            ['abbreviation' => 'NYG', 'conference' => 'NFC', 'division' => 'East'],
            ['abbreviation' => 'PHI', 'conference' => 'NFC', 'division' => 'East'],
            ['abbreviation' => 'WSH', 'conference' => 'NFC', 'division' => 'East'],

            // NFC North
            ['abbreviation' => 'CHI', 'conference' => 'NFC', 'division' => 'North'],
            ['abbreviation' => 'DET', 'conference' => 'NFC', 'division' => 'North'],
            ['abbreviation' => 'GB', 'conference' => 'NFC', 'division' => 'North'],
            ['abbreviation' => 'MIN', 'conference' => 'NFC', 'division' => 'North'],

            // NFC South
            ['abbreviation' => 'ATL', 'conference' => 'NFC', 'division' => 'South'],
            ['abbreviation' => 'CAR', 'conference' => 'NFC', 'division' => 'South'],
            ['abbreviation' => 'NO', 'conference' => 'NFC', 'division' => 'South'],
            ['abbreviation' => 'TB', 'conference' => 'NFC', 'division' => 'South'],

            // NFC West
            ['abbreviation' => 'ARI', 'conference' => 'NFC', 'division' => 'West'],
            ['abbreviation' => 'LAR', 'conference' => 'NFC', 'division' => 'West'],
            ['abbreviation' => 'SF', 'conference' => 'NFC', 'division' => 'West'],
            ['abbreviation' => 'SEA', 'conference' => 'NFC', 'division' => 'West'],
        ];

        foreach ($teamData as $data) {
            Team::where('abbreviation', $data['abbreviation'])
                ->update([
                    'conference' => $data['conference'],
                    'division' => $data['division']
                ]);
        }
    }

    public function down(): void
    {
        Team::query()->update([
            'conference' => null,
            'division' => null
        ]);
    }
};
