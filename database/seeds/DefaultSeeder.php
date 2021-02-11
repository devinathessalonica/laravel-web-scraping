<?php

use App\Models\Master\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create default role
        $role = Role::firstOrCreate(['name' => 'Admin']);

        // Create default user
        $user = User::firstOrCreate([
            'username' => 'admin',
            'name' => 'Administrator',
            'password' => Hash::make('admin')
        ]);

        // Assign user to "Admin"
        $user->assignRole('Admin');
    }
}
