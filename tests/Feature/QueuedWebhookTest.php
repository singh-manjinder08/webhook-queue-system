<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\QueuedWebhook;
use Illuminate\Support\Str;

class QueuedWebhookTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_queued_webhook()
    {
        $payload = [
            'transaction_id' => str::uuid(),
            'event_type' => 'TRANSACTION_CREATED',
            'payload' => [
                'order_id' => "order-1",
                'amount' => 20,
                'currency' => 'USD',
            ],
        ];

        $headers = ['Accept' => 'application/json'];

        $response = $this->postJson('api/v1/queued-webhooks', $payload, $headers);

        $response->assertStatus(200);

        $this->assertDatabaseHas('queued_webhooks', [
            'transaction_id' => $payload['transaction_id'],
        ]);
    }

    /** @test */
    public function it_lists_queued_webhooks()
    {
        QueuedWebhook::factory()->count(3)->create();

        $headers = ['Accept' => 'application/json'];

        $response = $this->getJson('/api/v1/queued-webhooks', $headers);

        $response->assertStatus(200)
                 ->assertJsonCount(3, 'data');
    }
}
