<?php

namespace Database\Seeders\Testing;

use Illuminate\Database\Seeder;
use Database\Seeders\Rangon\UserSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
