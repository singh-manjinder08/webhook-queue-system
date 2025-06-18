<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\QueuedWebhook;
use App\Jobs\ProcessWebhookJob;

class RetryHeldWebhooks extends Command
{
    protected $signature = 'webhooks:retry-held';
    protected $description = 'Retry held webhooks if prior ones are processed';

    public function handle()
    {
        $heldWebhooks = QueuedWebhook::where('status', 'hold')->get();

        foreach ($heldWebhooks as $webhook)
        {
            $isBlocked = QueuedWebhook::where('transaction_id', $webhook->transaction_id)
                ->whereIn('status', ['pending', 'inprogress'])
                ->where('id', '!=', $webhook->id)
                ->exists();

            if (! $isBlocked)
            {
                $webhook->update(['status' => 'pending']);
                ProcessWebhookJob::dispatch($webhook);
                $this->info("Re-dispatched webhook: " . $webhook->id);
            }
        }

        return Command::SUCCESS;
    }
}
