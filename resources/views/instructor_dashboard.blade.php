<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Instructor Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Course Management Section -->
                    <div class="mb-8">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold">My Courses</h3>
                            <a href="{{ route('courses.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create New Course
                            </a>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach(auth()->user()->instructorCourses as $course)
                            <div class="bg-white p-6 rounded-lg shadow-md">
                                <h4 class="font-semibold text-lg mb-2">{{ $course->name }}</h4>
                                <p class="text-gray-600 mb-4">{{ Str::limit($course->description, 100) }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm {{ $course->is_approved ? 'text-green-600' : 'text-yellow-600' }}">
                                        {{ $course->is_approved ? 'Approved' : 'Pending Approval' }}
                                    </span>
                                    <div class="space-x-2">
                                        <a href="{{ route('courses.edit', $course) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                        <a href="{{ route('courses.show', $course) }}" class="text-green-600 hover:text-green-900">View</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Course Statistics -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h3 class="text-lg font-semibold mb-4">Total Students</h3>
                            <p class="text-3xl font-bold">{{ auth()->user()->instructorCourses->flatMap->students->unique()->count() }}</p>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h3 class="text-lg font-semibold mb-4">Active Courses</h3>
                            <p class="text-3xl font-bold">{{ auth()->user()->instructorCourses->where('is_approved', true)->count() }}</p>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h3 class="text-lg font-semibold mb-4">Average Rating</h3>
                            <p class="text-3xl font-bold">
                                {{ number_format(auth()->user()->instructorCourses->flatMap->reviews->avg('rating'), 1) }}
                            </p>
                        </div>
                    </div>

                    <!-- Recent Reviews -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Recent Reviews</h3>
                        <div class="space-y-4">
                            @foreach(auth()->user()->instructorCourses->flatMap->reviews->sortByDesc('created_at')->take(5) as $review)
                            <div class="bg-white p-4 rounded-lg shadow-md">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-semibold">{{ $review->course->name }}</p>
                                        <p class="text-gray-600">{{ $review->user->name }}</p>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-yellow-400">★</span>
                                        <span class="ml-1">{{ $review->rating }}/5</span>
                                    </div>
                                </div>
                                <p class="mt-2 text-gray-700">{{ $review->comment }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
