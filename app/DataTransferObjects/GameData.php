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
        public Carbon $dateTime,
        public string $status,
        public VenueData $venue,
        public TeamData $homeTeam,
        public TeamData $awayTeam,
        public ?string $name = null,
        public ?string $shortName = null,
    ) {}

    public static function fromEspnData(array $gameData): self
    {
        $competition = $gameData['competitions'][0];
        $competitors = $competition['competitors'];

        //find home and away teams
        $homeCompetitor = collect($competitors)->firstWhere('homeAway', 'home');
        $awayCompetitor = collect($competitors)->firstWhere('homeAway', 'away');

        $week = $gameData['$meta']['parameters']['week'][0] ?? 1;


        return new self(
            espnId: $gameData['id'],
            week: (int) $week,
            season: $gameData['$meta']['parameters']['season'][0] ?? 2025,
            dateTime: Carbon::parse($gameData['date']),
            status: 'scheduled',
            venue: VenueData::fromEspnData($competition['venue']),
            homeTeam: TeamData::fromEspnCompetitor($homeCompetitor),
            awayTeam: TeamData::fromEspnCompetitor($awayCompetitor),
            name: $gameData['name'] ?? null,
            shortName: $gameData['shortName'] ?? null,
        );
    }
}
