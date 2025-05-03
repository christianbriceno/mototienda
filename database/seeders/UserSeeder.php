<?php

namespace Database\Seeders;

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
        if (app()->environment('production')) {
            User::factory()->create([
                'id'       => 0,
                'name'   => config('permission.super_admin_name'),
                'email'    => config('permission.super_admin_email'),
                'password' => Hash::make(config('permission.super_admin_password')),
            ])->assignRole(config('permission.super_admin_name'));
        } else {
            User::factory()->create([
                'id'       => 0,
                'name'   => config('permission.super_admin_name'),
                'email'    => config('permission.super_admin_email'),
                'password' => Hash::make(config('permission.super_admin_password')),
            ])->assignRole(config('permission.super_admin_name'));

            User::factory()->create([
                'name'  => 'Christian Administrador',
                'email' => 'christianadministrador@test.com',
            ])->assignRole(Role::NAME_ADMIN);

            User::factory()->create([
                'name'  => 'Vendedor',
                'email' => 'vendedor@test.com',
            ])->assignRole(Role::NAME_SELLER);

            User::factory()->create([
                'name'  => 'Cliente',
                'email' => 'cliente@test.com',
            ])->assignRole(Role::NAME_CLIENT);
        }
    }
}
