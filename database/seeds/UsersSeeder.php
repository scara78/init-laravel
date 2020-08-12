<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'     => 'admin',
            'role'     => 'admin',
            'email'    => 'admin@admin.com',
            'password' =>  bcrypt('123456'),
            'phone_number' => '987654321',
            'activated'    => 1
        ]);
    }
}
