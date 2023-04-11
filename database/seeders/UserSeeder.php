<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'first_name' => 'Mark Thaddeus',
                'last_name' => 'Manuel',
                'school' => 'Gordon College',
                'email' => '202010597@gordoncollege.edu.ph',
                'password' => Hash::make('albert')
            ]
        ];

        DB::table('users')->insert($users);
    }
}
