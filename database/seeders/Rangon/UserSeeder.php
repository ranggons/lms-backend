<?php

namespace Database\Seeders\Rangon;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $users = [
            [
                'name'          =>  'Founding Father',
                'email'         =>  'rangon@rangon.id',
                'password'      =>  bcrypt('password')
            ],
            [
                'name'          =>  'Ackyras',
                'email'         =>  'ackyras@rangon.id',
                'password'      =>  bcrypt('password')
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
