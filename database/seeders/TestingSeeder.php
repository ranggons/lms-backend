<?php

namespace Database\Seeders;

use Database\Seeders\Testing\RangonSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestingSeeder extends Seeder
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
                RangonSeeder::class
            ]
        );
    }
}
