<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        Permission::create(['name' => 'edit any comment']);
        Permission::create(['name' => 'delete any comment']);
        Permission::create(['name' => 'edit any post']);
        Permission::create(['name' => 'delete any post']);
        
        $rolModerador = Role::create(['name' => 'moderator']);
        $rolAdmin = Role::create(['name' => 'admin']);
        
        $rolModerador->givePermissionTo(['edit any comment', 'delete any comment']);
        $rolAdmin->givePermissionTo(['edit any comment', 'delete any comment', 'edit any post', 'delete any post']);
    }
}
