<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\QueuedWebhook;
use App\Jobs\ProcessWebhookJob;
use Illuminate\Support\Facades\Queue;

class RetryWebhookJobTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_dispatches_retry_job_for_held_webhooks()
    {
        Queue::fake();

        $webhook = QueuedWebhook::factory()->create([
            'transaction_id' => 'txn-1',
            'status' => 'hold',
            'retry_attempts' => 1,
        ]);

        $this->artisan('webhooks:retry-held')->assertExitCode(0);

        Queue::assertPushed(ProcessWebhookJob::class, function ($job) use ($webhook) {
            return $job->webhook->is($webhook);
        });
    }

    /** @test */
    public function it_does_not_dispatch_if_retry_limit_reached()
    {
        Queue::fake();

        $webhook = QueuedWebhook::factory()->create([
            'transaction_id' => 'txn-2',
            'status' => 'hold',
            'retry_attempts' => 3,
        ]);

        $this->artisan('webhooks:retry-held')->assertExitCode(0);

        Queue::assertNothingPushed();
    }
}
