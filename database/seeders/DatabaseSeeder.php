<?php

namespace Database\Seeders;

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
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
        ]);
        $user = User::factory(1)->create();
        $user = $user->where("email", "=", "superadmin@" . env("APP_HOST", request()->getHost()))->first();
        $user->assignRole("Super Admin");
    }
}
