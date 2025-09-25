<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Enrollments;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\EnrollmentsController
 */
final class EnrollmentsControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $enrollments = Enrollments::factory()->count(3)->create();

        $response = $this->get(route('enrollments.index'));

        $response->assertOk();
        $response->assertViewIs('enrollment.index');
        $response->assertViewHas('enrollments');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('enrollments.create'));

        $response->assertOk();
        $response->assertViewIs('enrollment.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EnrollmentsController::class,
            'store',
            \App\Http\Requests\EnrollmentsStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $student = Student::factory()->create();
        $course = Course::factory()->create();
        $enrollment_date = fake()->;
        $status = fake()->randomElement(/** enum_attributes **/);

        $response = $this->post(route('enrollments.store'), [
            'student_id' => $student->id,
            'course_id' => $course->id,
            'enrollment_date' => $enrollment_date,
            'status' => $status,
        ]);

        $enrollments = Enrollment::query()
            ->where('student_id', $student->id)
            ->where('course_id', $course->id)
            ->where('enrollment_date', $enrollment_date)
            ->where('status', $status)
            ->get();
        $this->assertCount(1, $enrollments);
        $enrollment = $enrollments->first();

        $response->assertRedirect(route('enrollments.index'));
        $response->assertSessionHas('enrollment.id', $enrollment->id);
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $enrollment = Enrollments::factory()->create();

        $response = $this->get(route('enrollments.edit', $enrollment));

        $response->assertOk();
        $response->assertViewIs('enrollment.edit');
        $response->assertViewHas('enrollment');
    }
}
