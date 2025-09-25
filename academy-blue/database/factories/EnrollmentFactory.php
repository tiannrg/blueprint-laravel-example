<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;

class EnrollmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Enrollment::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'student_id' => User::factory(),
            'course_id' => Course::factory(),
            'enrollment_date' => fake()->word(),
            'status' => fake()->randomElement(["activo","completado","cancelado"]),
        ];
    }
}
