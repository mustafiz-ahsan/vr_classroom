<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,         // First create roles
            UsersTableSeeder::class,   // Then create users with roles
            CourseSeeder::class,       // Finally create courses
        ]);
    }
}
