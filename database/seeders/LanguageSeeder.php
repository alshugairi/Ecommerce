<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\Language;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Language::firstOrCreate(
            ['name' => 'English','code' => 'en'],
            ['name' => 'English','code' => 'en']
        );
        Language::firstOrCreate(
            ['name' => 'Arabic','code' => 'ar'],
            ['name' => 'Arabic','code' => 'ar']
        );
    }
}
