<?php

namespace App\Jobs;

use App\DataTransferObjects\GameData;
use App\Http\Integrations\ESPN\ESPNConnector;
use App\Http\Integrations\ESPN\Requests\GetGameDetailsRequest;
use App\Models\Game;
use App\Models\Team;
use App\Models\Venue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ProcessGameReference implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * The maximum number of seconds the job can run.
     */
    public int $timeout = 60;

    /**
     * The number of seconds to wait before retrying the job.
     */
    public int $backoff = 30;

    public function __construct(
        public string $gameReferenceUrl,
        public int $week = 1,
        public int $season = 2025,
        public int $seasonType = 2
    ) {}

    // In the handle method of ProcessGameReference job, add debugging:
    public function handle(): void
    {
        Log::info("Starting ProcessGameReference job", ['url' => $this->gameReferenceUrl]);

        try {
            // Extract game ID from reference URL
            $gameId = $this->extractGameId($this->gameReferenceUrl);
            Log::info("Extracted game ID: {$gameId}");

            // Fetch game details and get DTO directly
            $connector = new ESPNConnector();
            $request = new GetGameDetailsRequest($gameId);
            $response = $connector->send($request);

            Log::info("API Response status: " . $response->status());

            if (!$response->successful()) {
                Log::error("Failed to fetch game details for ID: {$gameId}", [
                    'status' => $response->status(),
                    'url' => $this->gameReferenceUrl
                ]);
                return;
            }

            Log::info("About to create DTO...");
            $gameData = GameData::fromEspnData($response->json(), $this->week, $this->season, $this->seasonType);
            Log::info("DTO created successfully", [
                'espn_id' => $gameData->espnId,
                'week' => $gameData->week,
                'season_type' => $gameData->seasonType,
                'home_team_id' => $gameData->homeTeam->espnId
            ]);

            // Store in database
            Log::info("About to store game data...");
            $this->storeGameData($gameData);
            Log::info("Game data stored successfully");

        } catch (\Exception $e) {
            Log::error("Error in ProcessGameReference job", [
                'url' => $this->gameReferenceUrl,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            throw $e; // Re-throw so the job fails visibly
        }
    }

    private function extractGameId(string $url): string
    {
        // Extract game ID from URL like:
        // http://sports.core.api.espn.com/v2/sports/football/leagues/nfl/events/401772510
        return basename(parse_url($url, PHP_URL_PATH));
    }

    private function storeGameData(GameData $gameData): void
    {
        DB::transaction(function () use ($gameData) {
            // Create/update venue
            $venue = Venue::updateOrCreate(
                ['espn_id' => $gameData->venue->espnId],
                [
                    'name' => $gameData->venue->name,
                    'city' => $gameData->venue->city,
                    'state' => $gameData->venue->state,
                    'capacity' => $gameData->venue->capacity,
                    'dome' => $gameData->venue->dome,
                    'surface_type' => $gameData->venue->surface,
                ]
            );

            // Create/update teams
            $homeTeam = Team::updateOrCreate(
                ['espn_id' => $gameData->homeTeam->espnId],
                [
                    'name' => $gameData->homeTeam->name,
                    'abbreviation' => $gameData->homeTeam->abbreviation,
                    'primary_color' => $gameData->homeTeam->primaryColor,
                    'secondary_color' => $gameData->homeTeam->secondaryColor,
                    'logo_url' => $gameData->homeTeam->logoUrl,
                ]
            );

            $awayTeam = Team::updateOrCreate(
                ['espn_id' => $gameData->awayTeam->espnId],
                [
                    'name' => $gameData->awayTeam->name,
                    'abbreviation' => $gameData->awayTeam->abbreviation,
                    'primary_color' => $gameData->awayTeam->primaryColor,
                    'secondary_color' => $gameData->awayTeam->secondaryColor,
                    'logo_url' => $gameData->awayTeam->logoUrl,
                ]
            );

            // Create/update game
            $game = Game::updateOrCreate(
                ['espn_id' => $gameData->espnId],
                [
                    'week' => $gameData->week,
                    'season' => $gameData->season,
                    'season_type' => $gameData->seasonType,
                    'date_time' => $gameData->dateTime,
                    'venue_id' => $venue->id,
                    'status' => $gameData->status,
                ]
            );

            // Create game-team relationships
            $game->gameTeams()->updateOrCreate(
                ['team_id' => $homeTeam->id],
                ['is_home' => true]
            );

            $game->gameTeams()->updateOrCreate(
                ['team_id' => $awayTeam->id],
                ['is_home' => false]
            );

            Log::info("Stored game data in database", [
                'game_id' => $game->id,
                'home_team' => $homeTeam->name,
                'away_team' => $awayTeam->name
            ]);
        }, 3); // 3 retry attempts for deadlocks
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("ProcessGameReference job failed permanently", [
            'url' => $this->gameReferenceUrl,
            'error' => $exception->getMessage(),
            'attempts' => $this->attempts()
        ]);
    }
}
