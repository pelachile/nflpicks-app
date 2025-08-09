<?php

namespace App\Http\Integrations\ESPN\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetTeamDetailsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $teamId,
        protected int $season = 2025
    ) {}

    public function resolveEndpoint(): string
    {
        return "seasons/{$this->season}/teams/" . $this->teamId;
    }

    protected function defaultQuery(): array
    {
        return [
            'lang' => 'en',
            'region' => 'us',
        ];
    }
}
