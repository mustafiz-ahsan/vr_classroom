<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Truncate the tables to start fresh
        DB::table('role_user')->truncate();
        
        // Get or create roles
        $adminRole = Role::where('name', 'admin')->first();
        $instructorRole = Role::where('name', 'instructor')->first();
        $studentRole = Role::where('name', 'student')->first();

        if (!$adminRole || !$instructorRole || !$studentRole) {
            $this->command->info('Required roles not found. Please run RolesTableSeeder first.');
            return;
        }

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@vrclassroom.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );
        DB::table('role_user')->insert([
            'user_id' => $admin->id,
            'role_id' => $adminRole->id,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Create instructor user
        $instructor = User::firstOrCreate(
            ['email' => 'instructor@vrclassroom.com'],
            [
                'name' => 'Instructor User',
                'password' => Hash::make('instructor123'),
                'email_verified_at' => now(),
            ]
        );
        DB::table('role_user')->insert([
            'user_id' => $instructor->id,
            'role_id' => $instructorRole->id,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Create student user
        $student = User::firstOrCreate(
            ['email' => 'student@vrclassroom.com'],
            [
                'name' => 'Student User',
                'password' => Hash::make('student123'),
                'email_verified_at' => now(),
            ]
        );
        DB::table('role_user')->insert([
            'user_id' => $student->id,
            'role_id' => $studentRole->id,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
