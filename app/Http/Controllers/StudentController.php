<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Review;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function dashboard()
    {
        $enrollments = auth()->user()->enrollments()->with('course')->get();
        return view('student.dashboard', compact('enrollments'));
    }

    public function enroll(Course $course)
    {
        auth()->user()->enrollments()->create([
            'course_id' => $course->id
        ]);

        return redirect()->route('student.dashboard')->with('success', 'Enrolled successfully');
    }

    public function updateProgress(Request $request, Enrollment $enrollment)
    {
        $validated = $request->validate([
            'progress' => 'required|integer|min:0|max:100'
        ]);

        $enrollment->update($validated);

        return redirect()->back()->with('success', 'Progress updated successfully');
    }

    public function review(Request $request, Course $course)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string'
        ]);

        Review::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'course_id' => $course->id
            ],
            $validated
        );

        return redirect()->back()->with('success', 'Review submitted successfully');
    }
}
