<?php

namespace App\Http\Integrations\ESPN;

use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;

class ESPNConnector extends Connector
{
    use AcceptsJson;

    /**
     * The Base URL of the API
     */
    public function resolveBaseUrl(): string
    {
        return 'http://sports.core.api.espn.com/v2/sports/football/leagues/nfl/';
    }

    /**
     * Default headers for every request
     */
    // In ESPNConnector.php
    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
        ];
    }

    /**
     * Default HTTP client options
     */
    protected function defaultConfig(): array
    {
        return [];
    }
}
