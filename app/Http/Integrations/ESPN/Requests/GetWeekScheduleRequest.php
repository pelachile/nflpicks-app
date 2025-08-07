<?php

namespace App\Http\Integrations\ESPN\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetWeekScheduleRequest extends Request
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;

    public function __construct(protected int $week = 1, protected int $season = 2025, protected int $seasonType = 2)
    {}

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return 'seasons/' . $this->season . '/types/'. $this->seasonType . '/weeks/' . $this->week . '/events';
    }
}
