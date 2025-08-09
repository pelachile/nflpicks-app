<?php

namespace App\Http\Integrations\ESPN\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetGameScoresRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $gameId
    ) {}

    public function resolveEndpoint(): string
    {
        return "events/" . $this->gameId;
    }

    protected function defaultQuery(): array
    {
        return [
            'lang' => 'en',
            'region' => 'us',
        ];
    }

    public function createDtoFromResponse(Response $response): array
    {
        $data = $response->json();
        $competition = $data['competitions'][0];
        $competitors = $competition['competitors'];

        $homeCompetitor = collect($competitors)->firstWhere('homeAway', 'home');
        $awayCompetitor = collect($competitors)->firstWhere('homeAway', 'away');

        return [
            'espn_id' => $data['id'],
            'status' => $competition['status']['type']['name'] ?? 'scheduled',
            'completed' => $competition['status']['type']['completed'] ?? false,
            'home_team' => [
                'espn_id' => $homeCompetitor['id'],
                'score' => (int) ($homeCompetitor['score'] ?? 0),
            ],
            'away_team' => [
                'espn_id' => $awayCompetitor['id'],
                'score' => (int) ($awayCompetitor['score'] ?? 0),
            ],
            'total_score' => ((int) ($homeCompetitor['score'] ?? 0)) + ((int) ($awayCompetitor['score'] ?? 0)),
        ];
    }
}