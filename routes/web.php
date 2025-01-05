<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/debug/courses', function() {
    dd(App\Models\Course::with(['instructor', 'reviews'])->get());
});

// Public routes
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin routes
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
        Route::get('/admin/courses', [CourseController::class, 'adminIndex'])->name('admin.courses');
        Route::post('/admin/courses/{course}/approve', [CourseController::class, 'approve'])->name('courses.approve');
        Route::post('/admin/courses/{course}/reject', [CourseController::class, 'reject'])->name('courses.reject');
    });

    // Instructor routes
    Route::middleware(['role:instructor'])->group(function () {
        Route::resource('courses', CourseController::class)->except(['index', 'show']);
    });

    // Student routes
    Route::middleware(['role:student'])->group(function () {
        Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'store'])->name('courses.enroll');
        Route::post('/courses/{course}/review', [ReviewController::class, 'store'])->name('courses.review');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
