<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            "user.create", "user.update", "user.delete", "user.view", "user.list",
            "role.create", "role.update", "role.delete", "role.view", "role.list"
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(["name" => $perm, "guard_name" => "web"]);
        }
    }
}
