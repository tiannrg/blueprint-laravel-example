<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CourseController
 */
final class CourseControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $courses = Course::factory()->count(3)->create();

        $response = $this->get(route('courses.index'));

        $response->assertOk();
        $response->assertViewIs('course.index');
        $response->assertViewHas('courses');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('courses.create'));

        $response->assertOk();
        $response->assertViewIs('course.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CourseController::class,
            'store',
            \App\Http\Requests\CourseStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $title = fake()->sentence(4);
        $price = fake()->numberBetween(-10000, 10000);
        $instructor = Instructor::factory()->create();
        $category = Category::factory()->create();

        $response = $this->post(route('courses.store'), [
            'title' => $title,
            'price' => $price,
            'instructor_id' => $instructor->id,
            'category_id' => $category->id,
        ]);

        $courses = Course::query()
            ->where('title', $title)
            ->where('price', $price)
            ->where('instructor_id', $instructor->id)
            ->where('category_id', $category->id)
            ->get();
        $this->assertCount(1, $courses);
        $course = $courses->first();

        $response->assertRedirect(route('courses.index'));
        $response->assertSessionHas('course.id', $course->id);
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $course = Course::factory()->create();

        $response = $this->get(route('courses.edit', $course));

        $response->assertOk();
        $response->assertViewIs('course.edit');
        $response->assertViewHas('course');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CourseController::class,
            'update',
            \App\Http\Requests\CourseUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $course = Course::factory()->create();
        $title = fake()->sentence(4);
        $price = fake()->numberBetween(-10000, 10000);
        $instructor = Instructor::factory()->create();
        $category = Category::factory()->create();

        $response = $this->put(route('courses.update', $course), [
            'title' => $title,
            'price' => $price,
            'instructor_id' => $instructor->id,
            'category_id' => $category->id,
        ]);

        $course->refresh();

        $response->assertRedirect(route('courses.index'));
        $response->assertSessionHas('course.id', $course->id);

        $this->assertEquals($title, $course->title);
        $this->assertEquals($price, $course->price);
        $this->assertEquals($instructor->id, $course->instructor_id);
        $this->assertEquals($category->id, $course->category_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $course = Course::factory()->create();

        $response = $this->delete(route('courses.destroy', $course));

        $response->assertRedirect(route('courses.index'));

        $this->assertModelMissing($course);
    }
}
