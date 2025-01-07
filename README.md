# VR Classroom

A modern web application built with Laravel and Tailwind CSS that provides an immersive virtual learning environment. Users can enroll in courses, track their progress, and leave reviews.

## Features

- User Authentication & Authorization (Admin, Instructor, Student roles)
- Course Management
- VR Content Integration
- Progress Tracking
- Course Reviews & Ratings
- Responsive Design with Tailwind CSS

## Prerequisites

- PHP >= 8.1
- MySQL >= 5.7
- Composer
- Node.js & NPM
- XAMPP (for local development)

## Installation

1. Clone the repository:
   ```bash
   git clone <repository-url>
   cd vr-classroom
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install NPM dependencies:
   ```bash
   npm install

   ```

4. Configure environment:
   - Copy `.env.example` to `.env`
   - Update database settings in `.env`
   - Generate application key: `php artisan key:generate`

5. Set up database:
   ```bash
   php artisan migrate
   ```
   php artisan db:seed

6. Build assets:
   ```bash
   npm run dev
   ```

7. Start the development server:
   ```bash
   php artisan serve
   ```

## Database Structure

- **Users**: Stores user information and authentication details
- **Roles**: Defines user roles (admin, instructor, student)
- **Courses**: Contains course information and VR content paths
- **Enrollments**: Tracks user enrollment and progress
- **Reviews**: Stores course ratings and reviews




