<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Progress Overview -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h3 class="text-lg font-semibold mb-4">Enrolled Courses</h3>
                            <p class="text-3xl font-bold">{{ auth()->user()->enrollments->count() }}</p>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h3 class="text-lg font-semibold mb-4">Completed Courses</h3>
                            <p class="text-3xl font-bold">{{ auth()->user()->enrollments->whereNotNull('completed_at')->count() }}</p>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h3 class="text-lg font-semibold mb-4">Average Progress</h3>
                            <p class="text-3xl font-bold">{{ number_format(auth()->user()->enrollments->avg('progress'), 0) }}%</p>
                        </div>
                    </div>

                    <!-- Current Courses -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">My Courses</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach(auth()->user()->enrollments as $enrollment)
                            <div class="bg-white p-6 rounded-lg shadow-md">
                                <h4 class="font-semibold text-lg mb-2">{{ $enrollment->course->name }}</h4>
                                <p class="text-gray-600 mb-4">{{ Str::limit($enrollment->course->description, 100) }}</p>
                                
                                <!-- Progress Bar -->
                                <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
                                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $enrollment->progress }}%"></div>
                                </div>
                                
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">{{ $enrollment->progress }}% Complete</span>
                                    <a href="{{ route('courses.show', $enrollment->course) }}" class="text-blue-600 hover:text-blue-900">
                                        Continue Learning
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Recommended Courses -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Recommended Courses</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach(\App\Models\Course::whereNotIn('id', auth()->user()->enrollments->pluck('course_id'))
                                ->where('is_approved', true)
                                ->inRandomOrder()
                                ->take(3)
                                ->get() as $course)
                            <div class="bg-white p-6 rounded-lg shadow-md">
                                <h4 class="font-semibold text-lg mb-2">{{ $course->name }}</h4>
                                <p class="text-gray-600 mb-4">{{ Str::limit($course->description, 100) }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">By {{ $course->instructor->name }}</span>
                                    <a href="{{ route('courses.show', $course) }}" class="text-blue-600 hover:text-blue-900">
                                        View Course
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
