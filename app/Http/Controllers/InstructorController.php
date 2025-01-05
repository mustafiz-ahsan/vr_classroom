<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InstructorController extends Controller
{
    public function dashboard()
    {
        $courses = auth()->user()->courses;
        return view('instructor.dashboard', compact('courses'));
    }
}
