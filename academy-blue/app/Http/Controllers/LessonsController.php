<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonStoreRequest;
use App\Http\Requests\LessonUpdateRequest;
use App\Models\Lesson;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LessonsController extends Controller
{
    public function index(Request $request): Response
    {
        $lessons = Lesson::all();

        return view('lesson.index', [
            'lessons' => $lessons,
        ]);
    }

    public function create(Request $request): Response
    {
        return view('lesson.create');
    }

    public function store(LessonStoreRequest $request): Response
    {
        $lesson = Lesson::create($request->validated());

        $request->session()->flash('lesson.id', $lesson->id);

        return redirect()->route('lessons.index');
    }

    public function edit(Request $request, Lesson $lesson): Response
    {
        return view('lesson.edit', [
            'lesson' => $lesson,
        ]);
    }

    public function update(LessonUpdateRequest $request, Lesson $lesson): Response
    {
        $lesson->update($request->validated());

        $request->session()->flash('lesson.id', $lesson->id);

        return redirect()->route('lessons.index');
    }

    public function destroy(Request $request, Lesson $lesson): Response
    {
        $lesson->delete();

        return redirect()->route('lessons.index');
    }
}
