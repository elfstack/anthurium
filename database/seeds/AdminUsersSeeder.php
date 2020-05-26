<?php

use App\Models\AdminUser;
use Illuminate\Database\Seeder;

class AdminUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = AdminUser::create([
            'name' => 'Jane Doe',
            'email' => 'admin@example.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'email_verified_at' => now(),
        ]);

        $superAdmin->assignRole('Super Admin');

        factory(AdminUser::class, 10)->create();
    }
}
