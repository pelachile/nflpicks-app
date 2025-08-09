<?php

namespace App\Http\Integrations\ESPN\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetWeekScoreboardRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected int $week = 1,
        protected int $season = 2025,
        protected int $seasonType = 2
    ) {}

    public function resolveEndpoint(): string
    {
        // Use ESPN Site API instead of Core API - has complete data
        return "https://site.api.espn.com/apis/site/v2/sports/football/nfl/scoreboard";
    }

    protected function defaultQuery(): array
    {
        return [
            'seasontype' => $this->seasonType,
            'week' => $this->week,
            'year' => $this->season,
        ];
    }

    public function createDtoFromResponse(Response $response): array
    {
        $data = $response->json();
        $games = [];

        if (!isset($data['events'])) {
            return $games;
        }

        foreach ($data['events'] as $event) {
            $competition = $event['competitions'][0];
            $competitors = $competition['competitors'];

            $homeCompetitor = collect($competitors)->firstWhere('homeAway', 'home');
            $awayCompetitor = collect($competitors)->firstWhere('homeAway', 'away');

            $games[] = [
                'espn_id' => $event['id'],
                'status' => $this->mapEspnStatus($event['status']['type']['name'] ?? 'STATUS_SCHEDULED'),
                'completed' => $event['status']['type']['completed'] ?? false,
                'home_team' => [
                    'espn_id' => $homeCompetitor['id'] ?? null,
                    'score' => (int) ($homeCompetitor['score'] ?? 0),
                ],
                'away_team' => [
                    'espn_id' => $awayCompetitor['id'] ?? null,
                    'score' => (int) ($awayCompetitor['score'] ?? 0),
                ],
                'total_score' => ((int) ($homeCompetitor['score'] ?? 0)) + ((int) ($awayCompetitor['score'] ?? 0)),
            ];
        }

        return $games;
    }

    private function mapEspnStatus(string $espnStatus): string
    {
        return match($espnStatus) {
            'STATUS_SCHEDULED' => 'scheduled',
            'STATUS_IN_PROGRESS' => 'in_progress',
            'STATUS_FINAL' => 'completed',
            'STATUS_HALFTIME' => 'in_progress',
            'STATUS_END_PERIOD' => 'in_progress',
            default => 'scheduled',
        };
    }
}