<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 50)->create()->each(function ($user) {
            $user->volunteerInfo()->save(factory(App\Models\VolunteerInfo::class)->make());
        });

        $user = Brackets\AdminAuth\Models\AdminUser::create([
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'vms@anthurium.elfstack.com',
            'password' => Hash::make('password')
        ]);

        $user->assignRole('administrator');
    }
}
