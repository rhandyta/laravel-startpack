<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Buat role "Super Admin"
         $role = Role::firstOrCreate(["name" => "Super Admin", "guard_name" => "web"]);
         $role = Role::firstOrCreate(["name" => "Admin", "guard_name" => "web"]);

         // Ambil semua permission dan berikan ke Super Admin
        //  $role->syncPermissions(Permission::all());
    }
}
