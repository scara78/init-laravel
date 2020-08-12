<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Role::where('name', '=', 'admin')->first() === null) {
            $adminRole = Role::create([
                'name'        => 'admin',
            ]);
        }

        if (Role::where('name', '=', 'user')->first() === null) {
            $userRole = Role::create([
                'name'        => 'user',
            ]);
        }
    }
}
