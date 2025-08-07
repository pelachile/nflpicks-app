<?php

namespace App\DataTransferObjects;

readonly class VenueData
{
    public function __construct(
        public ?string $espnId,
        public string $name,
        public string $city,
        public string $state,
        public ?int $capacity = null,
        public ?bool $dome = null,
        public ?string $surface = null,
    ) {}

    public static function fromEspnData(array $venueData): self
    {
        return new self(
            espnId: $venueData['id'] ?? null,
            name: $venueData['fullName'] ?? 'Unknown Venue',
            city: $venueData['address']['city'] ?? 'Unknown City',
            state: $venueData['address']['state'] ?? 'Unknown State',
            capacity: $venueData['capacity'] ?? null,
            dome: $venueData['indoor'] ?? null,
            surface: $venueData['grass'] ?? null,
        );
    }
}
