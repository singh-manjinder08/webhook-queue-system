<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('queued_webhooks', function (Blueprint $table) {
            $table->id();
            $table->uuid('transaction_id');
            $table->string('event_type');
            $table->json('payload');
            $table->enum('status', ['pending', 'inprogress', 'hold', 'failed', 'completed'])->default('pending');
            $table->json('response_log')->nullable();
            $table->unsignedTinyInteger('retry_attempts')->default(0);
            $table->timestamp('last_attempt_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queued_webhooks');
    }
};
