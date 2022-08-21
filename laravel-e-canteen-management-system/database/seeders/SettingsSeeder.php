<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            ['key' => 'app_name', 'value' => 'E-Canteen Management System'],
            ['key' => 'currency_symbol', 'value' => '$']
        ];

        foreach($datas as $data){
            Setting::Create($data);
        }

        

    }
}
