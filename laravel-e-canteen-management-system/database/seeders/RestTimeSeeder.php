<?php

namespace Database\Seeders;

use App\Models\RestTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RestTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RestTime::create([
            'day_id' => 1,
            'start_time' => '12:00 PM',
            'end_time' => '12:10 PM',
        ]);
    }
}
