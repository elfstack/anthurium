<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_groups')->insert([
            [
                'id' => 1,
                'name' => 'Guest',
                'level' => 1
            ],
            [
                'id' => 2,
                'name' => 'Member',
                'level' => 2
            ]
        ]);
        factory(User::class, 10)->create();
    }
}
