<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnrollmentStoreRequest;
use App\Models\Enrollment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EnrollmentsController extends Controller
{
    public function index(Request $request): Response
    {
        $enrollments = Enrollment::all();

        return view('enrollment.index', [
            'enrollments' => $enrollments,
        ]);
    }

    public function create(Request $request): Response
    {
        return view('enrollment.create');
    }

    public function store(EnrollmentStoreRequest $request): Response
    {
        $enrollment = Enrollment::create($request->validated());

        $request->session()->flash('enrollment.id', $enrollment->id);

        return redirect()->route('enrollments.index');
    }

    public function edit(Request $request, Enrollment $enrollment): Response
    {
        return view('enrollment.edit', [
            'enrollment' => $enrollment,
        ]);
    }
}
