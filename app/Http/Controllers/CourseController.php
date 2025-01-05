<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(): View
    {
        $courses = Course::with(['instructor', 'reviews'])
            ->where('is_approved', true)
            ->latest()
            ->paginate(12);

        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $course = Course::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'instructor_id' => auth()->id(),
        ]);

        return redirect()->route('instructor.dashboard')->with('success', 'Course created successfully');
    }

    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $course->update($validated);

        return redirect()->route('instructor.dashboard')->with('success', 'Course updated successfully');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('instructor.dashboard')->with('success', 'Course deleted successfully');
    }

    public function show(Course $course): View
    {
        $course->load(['instructor', 'reviews.user']);
        $averageRating = $course->reviews->avg('rating');
        
        return view('courses.show', compact('course', 'averageRating'));
    }
}
