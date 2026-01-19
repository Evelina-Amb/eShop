<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        Setting::updateOrCreate(
            ['key' => 'APP_NAME'],
            ['value' => env('APP_NAME')]
        );

        Setting::updateOrCreate(
            ['key' => 'APP_URL'],
            ['value' => env('APP_URL')]
        );

        Setting::updateOrCreate(
            ['key' => 'SANCTUM_STATEFUL_DOMAINS'],
            ['value' => env('SANCTUM_STATEFUL_DOMAINS')]
        );

        Setting::updateOrCreate(
            ['key' => 'SESSION_DOMAIN'],
            ['value' => env('SESSION_DOMAIN')]
        );
    }
}
