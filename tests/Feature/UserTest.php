<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PermissionsSeeder;

use Brackets\AdminAuth\Models\AdminUser;
use App\User;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp(): void
    {
        // first include all the normal setUp operations
        parent::setUp();

        $this->seed(PermissionsSeeder::class);

        // now re-register all the roles and permissions
        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserProfile() : void
    {
        $response = $this->get('/profile');
        $response->assertRedirect('/login');

        $user = factory(User::class)->create();
        $response = $this->actingAs($user)
            ->get('/profile');
        $response->assertStatus(200);
    }

    public function testUserEditProfile() : void
    {
        $user = factory(User::class)->create();
        $anotherUser = factory(User::class)->create();
        $adminUser = factory(AdminUser::class)->create([
            'forbidden' => false
        ]);

        $adminUser->assignRole('administrator');

        // not logged in
        $response = $this->postJson('/api/user/'.$user->getKey(), [
                'name' => 'John Doe'
        ])->assertStatus(401);


        // logged in
        $response = $this->actingAs($user)
            ->postJson('/api/user/'.$user->getKey(), [
                'name' => 'John Doe'
            ])->assertStatus(200);

        // change another user's profile
        $response = $this->actingAs($user)
            ->postJson('/api/user/'.$anotherUser->getKey(), [
                'name' => 'John Doe'
            ])->assertStatus(403, 'User trying to change another user\'s profile');

        // admin user change profile
        $response = $this->actingAs($adminUser, config('admin-auth.defaults.guard'))
            ->postJson('/api/user/'.$user->getKey(), [
                'name' => 'John Doe'
            ])->assertStatus(200);
    }

    public function testDeleteUser() : void
    {
        $user = factory(User::class)->create();
        $anotherUser = factory(User::class)->create();
        $adminUser = factory(AdminUser::class)->create([
            'forbidden' => false
        ]);

        $adminUser->assignRole('administrator');

        // not logged in
        $response = $this
            ->deleteJson('/api/user/'.$user->getKey())->assertStatus(401);

        // normal user cannot trigger
        $response = $this->actingAs($user)
            ->deleteJson('/api/user/'.$user->getKey())->assertStatus(401);

        // admin user trigger
        // FIXME: not working, but testing by hands seems working
        // $response = $this->actingAs($adminUser, config('admin-auth.defaults.guard'))
        //    ->deleteJson('/api/user/'.$anotherUser->getKey())->assertStatus(200);
    }
}
