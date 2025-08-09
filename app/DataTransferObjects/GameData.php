<?php

namespace App\DataTransferObjects;

use Carbon\Carbon;

readonly class GameData
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public string $espnId,
        public int $week,
        public int $season,
        public int $seasonType,
        public Carbon $dateTime,
        public string $status,
        public VenueData $venue,
        public TeamData $homeTeam,
        public TeamData $awayTeam,
        public ?string $name = null,
        public ?string $shortName = null,
    ) {}

    public static function fromEspnData(array $gameData, int $week = 1, int $season = 2025, int $seasonType = 2): self
    {
        $competition = $gameData['competitions'][0];
        $competitors = $competition['competitors'];

        //find home and away teams
        $homeCompetitor = collect($competitors)->firstWhere('homeAway', 'home');
        $awayCompetitor = collect($competitors)->firstWhere('homeAway', 'away');

        // Extract status - for individual game endpoints, the status might be a reference
        // For actual status, we need to make additional API calls or default to scheduled
        $status = 'scheduled'; // Default status
        if (isset($competition['status']['type']['name'])) {
            $status = strtolower($competition['status']['type']['name']);
        }

        return new self(
            espnId: $gameData['id'],
            week: $week,
            season: $season,
            seasonType: $seasonType,
            dateTime: Carbon::parse($gameData['date']),
            status: $status,
            venue: VenueData::fromEspnData($competition['venue'] ?? []),
            homeTeam: TeamData::fromEspnCompetitor($homeCompetitor),
            awayTeam: TeamData::fromEspnCompetitor($awayCompetitor),
            name: $gameData['name'] ?? null,
            shortName: $gameData['shortName'] ?? null,
        );
    }
}
