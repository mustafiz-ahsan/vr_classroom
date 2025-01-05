<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ]);

        // Check if user is enrolled in the course
        if (!$course->students()->where('user_id', Auth::id())->exists()) {
            return redirect()->back()->with('error', 'You must be enrolled in the course to leave a review.');
        }

        // Check if user has already reviewed the course
        if ($course->reviews()->where('user_id', Auth::id())->exists()) {
            return redirect()->back()->with('error', 'You have already reviewed this course.');
        }

        $course->reviews()->create([
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return redirect()->back()->with('success', 'Review submitted successfully.');
    }
}
