<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function run()
    {
        $this->resetPermissions();

        $permissions = collect([
            'admin.users',
            'admin.user-groups',

            // operation
            'admin.activities',
            'admin.data-collection',
            'admin.roles',
            'admin.audits',
            'admin.admin-users',
        ]);

        $permissions->each(function ($permission) {
            Permission::create(['guard_name' => 'admin_api', 'name' => $permission]);
        });

        Role::findByName('Super Admin', 'admin_api')->givePermissionTo(Permission::all());
    }

    /**
     * Reset all permissions
     */
    private function resetPermissions()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Schema::disableForeignKeyConstraints();
        DB::table('role_has_permissions')->truncate();
        DB::table('permissions')->truncate();
        Schema::enableForeignKeyConstraints();
    }
}
