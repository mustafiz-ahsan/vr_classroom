<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-semibold mb-6">VR Courses</h1>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($courses as $course)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                                @if($course->thumbnail_path)
                                    <img src="{{ asset('storage/' . $course->thumbnail_path) }}" alt="{{ $course->name }}" class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-400">No thumbnail</span>
                                    </div>
                                @endif

                                <div class="p-4">
                                    <h2 class="text-xl font-semibold mb-2">{{ $course->name }}</h2>
                                    <p class="text-gray-600 mb-4 line-clamp-2">{{ $course->description }}</p>
                                    
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center">
                                            <span class="text-gray-600">By {{ $course->instructor->name }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                            <span class="ml-1 text-gray-600">{{ number_format($course->reviews->avg('rating'), 1) }}</span>
                                            <span class="ml-1 text-gray-500">({{ $course->reviews->count() }})</span>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-600">{{ $course->duration_minutes }} minutes</span>
                                        <a href="{{ route('courses.show', $course) }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">View Course</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $courses->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
