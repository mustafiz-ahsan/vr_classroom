<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function store(Course $course)
    {
        // Check if user is already enrolled
        if (!$course->students()->where('user_id', Auth::id())->exists()) {
            $course->students()->attach(Auth::id(), [
                'created_at' => now(),
                'updated_at' => now()
            ]);
            return redirect()->back()->with('success', 'Successfully enrolled in the course.');
        }
        return redirect()->back()->with('error', 'You are already enrolled in this course.');
    }

    public function destroy(Course $course)
    {
        $course->students()->detach(Auth::id());
        return redirect()->back()->with('success', 'Successfully unenrolled from the course.');
    }
}
