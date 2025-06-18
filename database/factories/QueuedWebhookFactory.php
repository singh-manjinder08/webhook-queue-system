<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QueuedWebhook>
 */
class QueuedWebhookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'transaction_id' => Str::uuid(),
            'event_type' => $this->faker->randomElement(['TRANSACTION_CREATED', 'TRANSACTION_PENDING', 'TRANSACTION_COMPLETED', 'TRANSACTION_FAILED']),
            'payload' => [
                'order_id' => $this->faker->uuid,
                'amount' => $this->faker->randomFloat(2, 10, 500),
                'currency' => 'USD',
            ],
            'status' => 'pending',
            'response_log' => null,
            'retry_attempts' => 0,
            'last_attempt_at' => null,
        ];
    }
}
