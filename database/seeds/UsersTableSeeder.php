<?php

use Illuminate\Database\Seeder;
use App\User;
use \carbon\carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $users = [
            'name' => 'seocom',
            'email' => 'seocom@gmail.com',
            'password' => bcrypt('admins'),
            'role'    => 'admin',
            'created_at' => carbon::now(),
            'updated_at' => carbon::now(),
        ];

        User::insert($users);

    	factory(App\User::class, 4)->create();
    }
}
