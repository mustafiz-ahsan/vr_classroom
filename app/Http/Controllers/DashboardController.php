<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $userRole = $user->roles->first()?->name;

        if (!$userRole) {
            return view('dashboard');
        }

        return match ($userRole) {
            'student' => $this->studentDashboard($user),
            'instructor' => $this->instructorDashboard($user),
            'admin' => $this->adminDashboard($user),
            default => view('dashboard'),
        };
    }

    private function studentDashboard($user): View
    {
        $enrolledCourses = $user->enrolledCourses()
            ->with(['instructor', 'reviews'])
            ->get();

        $availableCourses = Course::where('is_approved', true)
            ->whereDoesntHave('students', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with('instructor')
            ->latest()
            ->take(3)
            ->get();

        return view('student_dashboard', [
            'enrolledCourses' => $enrolledCourses,
            'availableCourses' => $availableCourses,
        ]);
    }

    private function instructorDashboard($user): View
    {
        $taughtCourses = $user->taughtCourses()
            ->withCount('students')
            ->withAvg('reviews', 'rating')
            ->get();

        $totalStudents = $taughtCourses->sum('students_count');
        $averageRating = $taughtCourses->avg('reviews_avg_rating') ?? 0;

        return view('instructor_dashboard', [
            'taughtCourses' => $taughtCourses,
            'totalStudents' => $totalStudents,
            'averageRating' => $averageRating,
        ]);
    }

    private function adminDashboard($user): View
    {
        return view('admin_dashboard');
    }
}
