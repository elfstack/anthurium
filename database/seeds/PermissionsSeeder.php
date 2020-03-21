<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;

class PermissionsSeeder extends Seeder
{
    /**
     * @var Repository|mixed
     */
    protected $adminGuardName;
    /**
     * @var Repository|mixed
     */
    protected $userGuardName;
    /**
     * @var mixed
     */
    protected $userModel;
    /**
     * @var mixed
     */
    protected $adminModel;
    /**
     * Default Password
     *
     * @var string
     */
    public function __construct()
    {
        $this->adminGuardName = config('admin-auth.defaults.guard');
        $this->userGuardName = config('auth.defaults.guard');

        $this->userModel = config('auth.providers.users.model');
        $this->adminModel = config('auth.providers.admin_users.model');
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $adminPermissions = collect([
            'admin',
            // manage users (access)
            'admin.admin-user.index',
            'admin.admin-user.create',
            'admin.admin-user.edit',
            'admin.admin-user.delete',
            // ability to upload
            'admin.upload'
        ]);

        $adminManageUsersPermissions = collect([
            'admin.user',
            'admin.user.index',
            'admin.user.create',
            'admin.user.show',
            'admin.user.edit',
            'admin.user.delete',
            'admin.user.bulk-delete',
        ]);

        $adminManageVolunteerInfosPermissions = collect([
            'admin.volunteer-info',
            'admin.volunteer-info.index',
            'admin.volunteer-info.create',
            'admin.volunteer-info.show',
            'admin.volunteer-info.edit',
            'admin.volunteer-info.delete',
            'admin.volunteer-info.bulk-delete',
        ]);

        $adminManageActivitiesPermissions = collect([
            'admin.activity',
            'admin.activity.index',
            'admin.activity.create',
            'admin.activity.show',
            'admin.activity.edit',
            'admin.activity.delete',
            'admin.activity.bulk-delete',
        ]);

        $adminManageAttendancePermissions = collect([
            'admin.attendance',
            'admin.attendance.index',
            'admin.attendance.create',
            'admin.attendance.show',
            'admin.attendance.edit',
            'admin.attendance.delete',
            'admin.attendance.bulk-delete',
        ]);

        $adminManageParticipantsPermissions = collect([
            'admin.participant',
            'admin.participant.index',
            'admin.participant.create',
            'admin.participant.show',
            'admin.participant.edit',
            'admin.participant.delete',
            'admin.participant.bulk-delete',
        ]);

        $this->registerAdminPermission($adminPermissions);
        $this->registerAdminPermission($adminManageUsersPermissions);
        $this->registerAdminPermission($adminManageVolunteerInfosPermissions);
        $this->registerAdminPermission($adminManageActivitiesPermissions);
        $this->registerAdminPermission($adminManageAttendancePermissions);
        $this->registerAdminPermission($adminManageParticipantsPermissions);

        $roleAdministrator = Role::create([
            'name' => 'administrator',
            'guard_name' => $this->adminGuardName
        ]);

        $roleAdministrator->givePermissionTo($adminPermissions);    
        $roleAdministrator->givePermissionTo($adminManageUsersPermissions);
        $roleAdministrator->givePermissionTo($adminManageVolunteerInfosPermissions);
        $roleAdministrator->givePermissionTo($adminManageActivitiesPermissions);
        $roleAdministrator->givePermissionTo($adminManageAttendancePermissions);
        $roleAdministrator->givePermissionTo($adminManageParticipantsPermissions);
    }

    private function registerAdminPermission($permissions): void
    {
        $permissions->each(function ($permission) {
            Permission::create([
                'name' => $permission, 
                'guard_name' => $this->adminGuardName
            ]);
        });
    }
}
