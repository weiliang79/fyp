<?php

namespace Database\Seeders;

use App\Models\Role;
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
        // admin
        User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'username' => 'admin',
            'role_id' => Role::ROLE_ADMIN,
            'email' => 'admin@isp.com',
        ]);

        // food seller
        User::factory()->create([
            'first_name' => 'Food',
            'last_name' => 'Seller',
            'username' => 'foodseller',
            'role_id' => Role::ROLE_SELLER,
            'email' => 'foodseller@isp.com',
        ]);
    }
}
