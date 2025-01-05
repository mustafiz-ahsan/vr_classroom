<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $pendingCourses = Course::where('is_approved', false)->with('instructor')->get();
        return view('admin.dashboard', compact('pendingCourses'));
    }

    public function approveCourse(Course $course)
    {
        $course->update(['is_approved' => true]);
        return redirect()->route('admin.dashboard')->with('success', 'Course approved successfully');
    }

    public function rejectCourse(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Course rejected successfully');
    }
}
