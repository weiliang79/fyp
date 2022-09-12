<?php

namespace Database\Seeders;

use App\Models\Student;
use Carbon\Carbon;
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
        $student = Student::factory()->create([
            'username' => 'student1',
            'email' => 'student1@isp.com',
            'email_verified_at' => Carbon::now(),
        ]);

        $student->restTimes()->attach(1);

        // student1
        $student = Student::factory()->create([
            'username' => 'student2',
            'email' => null,
            'email_verified_at' => null,
        ]);

        $student->restTimes()->attach(1);
    }
}
