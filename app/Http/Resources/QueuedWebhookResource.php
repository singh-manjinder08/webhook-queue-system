<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QueuedWebhookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'transaction_id'  => $this->transaction_id,
            'event_type'      => $this->event_type,
            'payload'         => $this->payload,
            'status'          => $this->status,
            'response_log'    => $this->response_log,
            'retry_attempts'  => $this->retry_attempts,
            'last_attempt_at' => $this->last_attempt_at,
            'created_at'      => $this->created_at,
        ];
    }
}
