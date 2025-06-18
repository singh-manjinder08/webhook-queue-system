<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueuedWebhook extends Model
{
    /** @use HasFactory<\Database\Factories\QueuedWebhookFactory> */
    use HasFactory;

   protected $fillable = [
        'id',
        'transaction_id',
        'event_type',
        'payload',
        'status',
        "response_log",
        'retry_attempts',
        'last_attempt_at',
    ];

    protected $casts = [
        'payload'         => 'array',
        'response_log'    => 'array',
        'last_attempt_at' => 'datetime',
    ];
}
