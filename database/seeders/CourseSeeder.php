<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $instructor = User::where('email', 'instructor@vrclassroom.com')->first();

        // Create some sample courses
        $courses = [
            [
                'name' => 'Introduction to Virtual Reality',
                'description' => 'Learn the basics of VR technology and development.',
                'is_approved' => true,
                'duration_minutes' => 120,
            ],
            [
                'name' => 'Advanced VR Development',
                'description' => 'Deep dive into VR development techniques and best practices.',
                'is_approved' => true,
                'duration_minutes' => 180,
            ],
            [
                'name' => 'VR User Experience Design',
                'description' => 'Learn how to create immersive and user-friendly VR experiences.',
                'is_approved' => false,
                'duration_minutes' => 150,
            ],
        ];

        foreach ($courses as $courseData) {
            Course::create([
                'name' => $courseData['name'],
                'description' => $courseData['description'],
                'instructor_id' => $instructor->id,
                'is_approved' => $courseData['is_approved'],
                'duration_minutes' => $courseData['duration_minutes'],
            ]);
        }
    }
}
