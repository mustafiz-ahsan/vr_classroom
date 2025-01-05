<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Create Course Button -->
            <div class="mb-6">
                <a href="{{ route('courses.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Create New Course
                </a>
            </div>

            <!-- My Courses -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">My Courses</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse ($courses as $course)
                            <div class="bg-white border rounded-lg overflow-hidden shadow-sm">
                                <div class="p-6">
                                    <div class="flex justify-between items-start mb-4">
                                        <h3 class="text-lg font-semibold text-gray-800">{{ $course->name }}</h3>
                                        <span class="px-2 py-1 text-xs font-semibold rounded {{ $course->is_approved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ $course->is_approved ? 'Approved' : 'Pending' }}
                                        </span>
                                    </div>
                                    
                                    <p class="text-gray-600 mb-4">{{ Str::limit($course->description, 100) }}</p>

                                    <!-- Course Statistics -->
                                    <div class="grid grid-cols-2 gap-4 mb-4">
                                        <div class="bg-gray-50 rounded p-3">
                                            <p class="text-sm text-gray-500">Enrolled Students</p>
                                            <p class="text-lg font-semibold text-gray-800">{{ $course->enrollments->count() }}</p>
                                        </div>
                                        <div class="bg-gray-50 rounded p-3">
                                            <p class="text-sm text-gray-500">Average Rating</p>
                                            <p class="text-lg font-semibold text-gray-800">
                                                {{ $course->reviews->avg('rating') ? number_format($course->reviews->avg('rating'), 1) : 'N/A' }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Course Actions -->
                                    <div class="flex justify-between items-center mt-4">
                                        <a href="{{ route('courses.edit', $course) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            Edit
                                        </a>
                                        
                                        <form action="{{ route('courses.destroy', $course) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this course?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3">
                                <p class="text-gray-600 text-center">You haven't created any courses yet.</p>
                                <div class="text-center mt-4">
                                    <a href="{{ route('courses.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Create Your First Course
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
