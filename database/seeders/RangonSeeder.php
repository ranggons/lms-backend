<?php

namespace Database\Seeders;

use Database\Seeders\Rangon\UserSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RangonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->call(
            [
                UserSeeder::class,
            ]
        );
    }
}
