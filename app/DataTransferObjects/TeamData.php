<?php

namespace App\DataTransferObjects;

readonly class TeamData
{
    public function __construct(
        public readonly string $espnId,
        public readonly string $name,
        public readonly string $abbreviation,
        public readonly string $displayName,
        public readonly ?string $primaryColor = null,
        public readonly ?string $secondaryColor = null,
        public readonly ?string $logoUrl = null,
        public readonly bool $isHome = false,
    ) {}

    public static function fromEspnCompetitor(array $competitor): self
    {

        return new self(
            espnId: $competitor['id'],
            name: 'Team' . $competitor['id'],
            abbreviation: 'T' . $competitor['id'],
            displayName: 'Team' . $competitor['id'],
            primaryColor: null,
            secondaryColor: null,
            logoUrl: null,
            isHome: $competitor['homeAway'] === 'home',
        );
    }
}
