<?php

namespace App\Jobs;

use App\Http\Integrations\ESPN\ESPNConnector;
use App\Http\Integrations\ESPN\Requests\GetTeamDetailsRequest;
use App\Models\Team;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class FetchTeamDetails implements ShouldQueue
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
        public string $teamId
    ) {}

    // Clean up the handle method (remove the echo statements)
    public function handle(): void
    {
        try {
            $connector = new ESPNConnector();
            $request = new GetTeamDetailsRequest($this->teamId);
            $response = $connector->send($request);

            if (!$response->successful()) {
                Log::error("Failed to fetch team details for ID: {$this->teamId}", [
                    'status' => $response->status(),
                ]);
                return;
            }

            $teamData = $response->json();
            $this->updateTeamData($teamData);

            Log::info("Successfully updated team: {$teamData['displayName']}");

        } catch (\Exception $e) {
            Log::error("Error fetching team details for ID: {$this->teamId}", [
                'error' => $e->getMessage()
            ]);
        }
    }

    private function updateTeamData(array $teamData): void
    {
        DB::transaction(function () use ($teamData) {
            $team = Team::where('espn_id', $this->teamId)->first();

            if (!$team) {
                Log::warning("Team not found with ESPN ID: {$this->teamId}");
                return;
            }

            $team->update([
                'name' => $teamData['displayName'] ?? $team->name,
                'abbreviation' => $teamData['abbreviation'] ?? $team->abbreviation,
                'primary_color' => $teamData['color'] ?? null,
                'secondary_color' => $teamData['alternateColor'] ?? null,
                'logo_url' => $teamData['logos'][0]['href'] ?? null,
            ]);
        }, 3); // 3 retry attempts for deadlocks
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("FetchTeamDetails job failed permanently", [
            'team_id' => $this->teamId,
            'error' => $exception->getMessage(),
            'attempts' => $this->attempts()
        ]);
    }
}
