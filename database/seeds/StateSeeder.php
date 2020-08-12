<?php

use Illuminate\Database\Seeder;
use App\State;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $states = [
            [
                'name'     => "inactive",
                'value'    => 0,
            ],
            [
                'name'     => "active",
                'value'    => 1,
            ],
            [
                'name'     => "sub",
                'value'    => 2,
            ]
        ];

        foreach ($states as $state) {
            $data = State::create([
                'name'     => $state['name'],
                'value'    => $state['value'],
            ]);
        }
    }
}
