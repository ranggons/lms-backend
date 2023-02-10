<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\Development\RangonSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DevelopmentSeeder extends Seeder
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
