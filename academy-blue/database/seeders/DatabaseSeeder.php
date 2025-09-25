<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       User::factory(1)->create([
        'role' => 'admin'
       ]);

        User::factory(5)->create([
        'role' => 'estudiantes'
       ]);

        User::factory(3)->create([
        'role' => 'instructores'
       ]);

       Category::factory(5)->create();
       Course::factory(10)->create();
       Lesson::factory(10)->create();
       Enrollment::factory(5)->create();
       
    }
}
