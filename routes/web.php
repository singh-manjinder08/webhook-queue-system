<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QueuedWebhookController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/webhooks-monitor', [QueuedWebhookController::class, 'monitor'])->name('webhooks.monitor');
Route::get('webhooks-monitor/{queued_webhook}/edit', [\App\Http\Controllers\QueuedWebhookController::class, 'edit'])->name('queued-webhooks.edit');
Route::put('/webhooks-monitor/{queued_webhook}', [QueuedWebhookController::class, 'update'])->name('webhooks.update');
