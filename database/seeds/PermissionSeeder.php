<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exitCode = Artisan::call('cache:clear');
        $admin = Role::where('name', 'Admin')->firstOrFail();
        $permissions = config('permissionuserkurs.permissions');
        foreach ($permissions as $module_name => $module_permissions) {
        	foreach ($module_permissions as $permission) {
        		$data = Permission::updateOrCreate([
        			'module_name' => $module_name,
        			'name' => $permission
        		]);
                $admin->givePermissionTo($permission);
        	}
        }
        $exitCode = Artisan::call('cache:clear');
    }
}
