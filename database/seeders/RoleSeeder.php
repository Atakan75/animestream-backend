<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_names = ['super-admin', 'admin', 'moderator', 'uploader', 'user'];
        foreach ($role_names as $role_name) {
            Role::create([
                'name' => $role_name,
                'guard_name' => 'web'
            ]);
        }
    }
}
