<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Role::create([
            'name' => 'Admin'
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 1
        ]);

        Menu::create([
            'id' => 1,
            'title' => 'Dashboard',
            'url' => 'dashboard',
            'order' => 1,
        ]);

        Menu::create([
            'id' => 2,
            'title' => 'Data Master',
            'order' => 1,
        ]);

        Menu::create([
            'id' => 3,
            'title' => 'Users',
            'url' => 'master.users.index',
            'parent_id' => 2,
            'order' => 1,
        ]);

        Menu::create([
            'id' => 4,
            'title' => 'Utility',
            'url' => 'master.utility.index',
            'parent_id' => 2,
            'order' => 1,
        ]);
    }
}
