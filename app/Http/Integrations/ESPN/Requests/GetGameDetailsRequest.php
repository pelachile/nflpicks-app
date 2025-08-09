<?php

namespace App\Http\Integrations\ESPN\Requests;

use App\DataTransferObjects\GameData;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetGameDetailsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $gameId
    ) {}

    public function resolveEndpoint(): string
    {
        return "/v2/sports/football/leagues/nfl/events/" . $this->gameId;
    }

    protected function defaultQuery(): array
    {
        return [
            'lang' => 'en',
            'region' => 'us',
        ];
    }

    public function createDtoFromResponse(Response $response): GameData
    {
        return GameData::fromEspnData($response->json());
    }
}
