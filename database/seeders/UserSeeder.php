<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'type' => UserType::Admin->value,
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => '12345678',
            ]
        );

        $adminRole = Role::where('name', 'admin')->first();

        if ($adminRole) {
            $adminUser->assignRole($adminRole);
        }
    }
}
