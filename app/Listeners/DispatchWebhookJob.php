<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\ProcessWebhookJob;
use App\Events\WebhookDispatched;
use App\Models\QueuedWebhook;

class DispatchWebhookJob
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(WebhookDispatched $event): void
    {
        $webhook = $event->webhook;

        // Check if another webhook is pending or inprogress for the same transaction
        $blocked = QueuedWebhook::where('transaction_id', $webhook->transaction_id)
            ->where('id', '!=', $webhook->id)
            ->whereIn('status', ['pending', 'inprogress'])
            ->exists();

        if ($blocked)
        {
            $webhook->update(['status' => 'hold']);
            return;
        }

        ProcessWebhookJob::dispatch($webhook);
    }
}
