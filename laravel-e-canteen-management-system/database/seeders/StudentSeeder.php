<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // student1
        Student::factory()->create([
            'username' => 'student1',
            'email' => null,
            'email_verified_at' => null,
        ]);
    }
}
