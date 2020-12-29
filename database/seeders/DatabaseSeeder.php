<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(5)
            ->hasPosts(5)
            ->create();
        
        $this->call(RolesAndPermissionsSeeder::class);
        
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@app.com',
            'password' => bcrypt('abc123123')
        ]);
        
        $admin->assignRole('admin');
        
        $mod = User::create([
            'name' => 'Moderador',
            'email' => 'moderador@app.com',
            'password' => bcrypt('abc123123')
        ]);
        
        $mod->assignRole('moderator');
        
        $user = User::create([
            'name' => 'Usuario',
            'email' => 'usuario@app.com',
            'password' => bcrypt('abc123123')
        ]);
    }
}
