<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::create([
        	'name' => 'admin',
        	'password' => bcrypt('admin'),
        	'email' => 'admin@gmail.com',
        	'admin' => 1,
        	'avatar' => asset('avatars/1.jpg')
		]);

        App\User::create([
        	'name' => 'Milen Cvetkov',
        	'password' => bcrypt('milen'),
        	'email' => 'milen@gmail.com',
        	'avatar' => asset('avatars/1.jpg')
		]);
    }
}
