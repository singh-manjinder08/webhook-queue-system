<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\QueuedWebhook;
use Illuminate\Support\Str;

class QueuedWebhookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       QueuedWebhook::factory()->count(10)->create();
    }
}
