<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()['cache']->forget('spatie.permission.cache');

        Role::create([
            'name'  => config('permission.super_admin_name'),
            'level' => Role::LEVEL_SUPER_ADMIN
        ]);

        $adminRole = Role::create([
            'name'  => Role::NAME_ADMIN,
            'level' => Role::LEVEL_ADMIN
        ]);

        $adminRole->givePermissionTo(
            Permission::where('level', '>=', $adminRole->level)->get()
        );

        $sellerRole = Role::create([
            'name'  => Role::NAME_SELLER,
            'level' => Role::LEVEL_SELLER
        ]);

        $sellerRole->givePermissionTo(
            Permission::where('level', '>=', $sellerRole->level)->get()
        );

        $clientRole = Role::create([
            'name'  => Role::NAME_CLIENT,
            'level' => Role::LEVEL_CLIENT
        ]);

        $clientRole->givePermissionTo(
            Permission::where('level', '>=', $clientRole->level)->get()
        );
    }
}
