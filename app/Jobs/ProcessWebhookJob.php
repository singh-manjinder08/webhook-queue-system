<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\QueuedWebhook;

class ProcessWebhookJob implements ShouldQueue
{
    use Queueable;

    /**
     * @var QueuedWebhook $webhook
     */
    private QueuedWebhook $webhook;

    /**
     * Create a new job instance.
     * @param QueuedWebhook $webhook
     */
    public function __construct(QueuedWebhook $webhook)
    {
        $this->webhook = $webhook;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->webhook->status !== 'pending')
        {
            return;
        }

        $this->webhook->update([
            'status'          => 'inprogress',
            'last_attempt_at' => now(),
        ]);

        $result = $this->sendWebhook($this->webhook->payload);
        $success = $result['success'];
        $responseLog = $result['log'];

        if ($success)
        {
            $this->webhook->update([
                'response_log' => $responseLog,
                'status'       => 'completed'
            ]);

            // $this->webhook->delete(); // or mark as 'completed' if you want to keep records
        }
        else
        {
            $this->webhook->increment('retry_attempts');

            $this->webhook->update([
                'response_log' => $responseLog,
            ]);

            if ($this->webhook->retry_attempts >= 3)
            {
                $this->webhook->update(['status' => 'failed']);
            }
            else
            {
                $this->webhook->update(['status' => 'hold']);
                // Optionally dispatch retry after delay
                ProcessWebhookJob::dispatch($this->webhook)->delay(now()->addMinutes(2));
            }
        }
    }

    private function sendWebhook(array $payload): array
    {
        // Fake implementation, replace with real HTTP call
        try {
            // Simulate HTTP call — replace with real HTTP logic
            $success = rand(0, 1) === 1;
            $response = [
                'attempted_at' => now()->toDateTimeString(),
                'status_code' => $success ? 200 : 500,
                'body' => $success ? 'Success' : 'Internal Server Error',
            ];

            return ['success' => $success, 'log' => $response];
        }
        catch (\Throwable $e)
        {
            return [
                'success' => false,
                'log' => [
                    'attempted_at' => now()->toDateTimeString(),
                    'error' => $e->getMessage(),
                ],
            ];
        }
    }
}
