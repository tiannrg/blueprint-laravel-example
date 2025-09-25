<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Lessons;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\LessonsController
 */
final class LessonsControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $lessons = Lessons::factory()->count(3)->create();

        $response = $this->get(route('lessons.index'));

        $response->assertOk();
        $response->assertViewIs('lesson.index');
        $response->assertViewHas('lessons');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('lessons.create'));

        $response->assertOk();
        $response->assertViewIs('lesson.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\LessonsController::class,
            'store',
            \App\Http\Requests\LessonsStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $title = fake()->sentence(4);
        $content = fake()->paragraphs(3, true);
        $order_number = fake()->numberBetween(-10000, 10000);
        $course = Course::factory()->create();

        $response = $this->post(route('lessons.store'), [
            'title' => $title,
            'content' => $content,
            'order_number' => $order_number,
            'course_id' => $course->id,
        ]);

        $lessons = Lesson::query()
            ->where('title', $title)
            ->where('content', $content)
            ->where('order_number', $order_number)
            ->where('course_id', $course->id)
            ->get();
        $this->assertCount(1, $lessons);
        $lesson = $lessons->first();

        $response->assertRedirect(route('lessons.index'));
        $response->assertSessionHas('lesson.id', $lesson->id);
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $lesson = Lessons::factory()->create();

        $response = $this->get(route('lessons.edit', $lesson));

        $response->assertOk();
        $response->assertViewIs('lesson.edit');
        $response->assertViewHas('lesson');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\LessonsController::class,
            'update',
            \App\Http\Requests\LessonsUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $lesson = Lessons::factory()->create();
        $title = fake()->sentence(4);
        $content = fake()->paragraphs(3, true);
        $order_number = fake()->numberBetween(-10000, 10000);
        $course = Course::factory()->create();

        $response = $this->put(route('lessons.update', $lesson), [
            'title' => $title,
            'content' => $content,
            'order_number' => $order_number,
            'course_id' => $course->id,
        ]);

        $lesson->refresh();

        $response->assertRedirect(route('lessons.index'));
        $response->assertSessionHas('lesson.id', $lesson->id);

        $this->assertEquals($title, $lesson->title);
        $this->assertEquals($content, $lesson->content);
        $this->assertEquals($order_number, $lesson->order_number);
        $this->assertEquals($course->id, $lesson->course_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $lesson = Lessons::factory()->create();
        $lesson = Lesson::factory()->create();

        $response = $this->delete(route('lessons.destroy', $lesson));

        $response->assertRedirect(route('lessons.index'));

        $this->assertModelMissing($lesson);
    }
}
