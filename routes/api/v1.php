<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QueuedWebhookController;

Route::middleware('accept.json')->group(function () {
    Route::apiResource('queued-webhooks', QueuedWebhookController::class);
});
