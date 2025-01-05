<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Users Stats -->
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h3 class="text-lg font-semibold mb-4">Users</h3>
                            <div class="space-y-2">
                                <p>Total Users: {{ \App\Models\User::count() }}</p>
                                <p>Students: {{ \App\Models\User::whereHas('roles', function($q) { $q->where('name', 'student'); })->count() }}</p>
                                <p>Instructors: {{ \App\Models\User::whereHas('roles', function($q) { $q->where('name', 'instructor'); })->count() }}</p>
                            </div>
                        </div>

                        <!-- Courses Stats -->
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h3 class="text-lg font-semibold mb-4">Courses</h3>
                            <div class="space-y-2">
                                <p>Total Courses: {{ \App\Models\Course::count() }}</p>
                                <p>Active Courses: {{ \App\Models\Course::where('is_approved', true)->count() }}</p>
                                <p>Pending Approval: {{ \App\Models\Course::where('is_approved', false)->count() }}</p>
                            </div>
                        </div>

                        <!-- Enrollments Stats -->
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h3 class="text-lg font-semibold mb-4">Enrollments</h3>
                            <div class="space-y-2">
                                <p>Total Enrollments: {{ \App\Models\Enrollment::count() }}</p>
                                <p>Completed Courses: {{ \App\Models\Enrollment::whereNotNull('completed_at')->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Course Approvals -->
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold mb-4">Pending Course Approvals</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Course</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Instructor</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Created</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(\App\Models\Course::where('is_approved', false)->with('instructor')->get() as $course)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $course->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $course->instructor->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $course->created_at->format('Y-m-d') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <form action="{{ route('courses.approve', $course) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-900">Approve</button>
                                            </form>
                                            <form action="{{ route('courses.reject', $course) }}" method="POST" class="inline ml-4">
                                                @csrf
                                                <button type="submit" class="text-red-600 hover:text-red-900">Reject</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
