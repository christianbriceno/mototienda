<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()['cache']->forget('spatie.permission.cache');

        $permissionsToCreate = [];

        $json = File::get("database/data/permissions.json");
        $permissions = json_decode($json);
        foreach ($permissions as $permission) {
            foreach ($permission->labels as $label) {
                $permissionsToCreate[] = [
                    'group'      => $permission->group,
                    'name'       => $label->name,
                    'route_name' => $label->route_name,
                    'level'      => $label->level,
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        Permission::insert($permissionsToCreate);
    }
}
