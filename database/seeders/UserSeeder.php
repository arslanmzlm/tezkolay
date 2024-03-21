<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create([
            'name' => 'Admin',
            'is_admin' => true,
        ]);

        $userRole = Role::create([
            'name' => 'User',
            'is_admin' => false,
        ]);

        User::factory()->create([
            'username' => 'admin',
            'email' => 'admin@tezkolay.test',
            'role_id' => $adminRole->id,
        ]);

        User::factory()->create([
            'username' => 'user',
            'email' => 'user@tezkolay.test',
            'role_id' => $userRole->id,
        ]);
    }
}
