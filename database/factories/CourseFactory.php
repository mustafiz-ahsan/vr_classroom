<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    protected $model = Course::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get or create an instructor
        $instructor = User::whereHas('role', function ($query) {
            $query->where('name', 'instructor');
        })->first();

        if (!$instructor) {
            $instructorRole = Role::where('name', 'instructor')->first();
            if (!$instructorRole) {
                $instructorRole = Role::create(['name' => 'instructor']);
            }
            
            $instructor = User::factory()->create([
                'name' => fake()->name(),
                'email' => 'instructor' . fake()->unique()->randomNumber(3) . '@vrclassroom.com',
                'password' => bcrypt('password'),
                'role_id' => $instructorRole->id,
                'email_verified_at' => now(),
            ]);
        }

        return [
            'name' => 'VR ' . fake()->words(3, true),
            'description' => fake()->paragraph(3),
            'instructor_id' => $instructor->id,
            'is_approved' => true,
            'thumbnail_path' => null,
            'vr_content_path' => null,
            'duration_minutes' => fake()->numberBetween(30, 180),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
