<?php

namespace App\Http\Integrations\ESPN\Requests;

use App\DataTransferObjects\GameData;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetGameDetailRequest extends Request
{

    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;

    public function __construct(protected int $gameId)
    {

    }
    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/events/' . $this->gameId;
    }

    protected function defaultQuery(): array
    {
        return [
            'lang' => 'en',
            'region' => 'us'
        ];
    }

    public function createDtoFromResponse(Response $response): GameData
    {
       return GameData::fromEspnData($response->json());
    }
}
