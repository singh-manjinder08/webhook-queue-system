<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\QueuedWebhook;

class QueuedWebhookTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_queued_webhook()
    {
        $payload = [
            'transaction_id' => 'tx-12345',
            'payload' => ['event' => 'test'],
            'url' => 'https://httpbin.org/post',
        ];

        $response = $this->postJson('/api/v1/queued-webhooks', $payload);

        $response->assertStatus(201)
                 ->assertJsonFragment(['transaction_id' => 'tx-12345']);

        $this->assertDatabaseHas('queued_webhooks', [
            'transaction_id' => 'tx-12345',
            'status' => 'pending',
        ]);
    }

    /** @test */
    public function it_lists_queued_webhooks()
    {
        QueuedWebhook::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/queued-webhooks');

        $response->assertStatus(200)
                 ->assertJsonCount(3, 'data');
    }
}
