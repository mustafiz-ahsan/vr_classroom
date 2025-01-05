<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $course->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Course Header -->
                    <div class="mb-8">
                        @if($course->thumbnail_path)
                            <img src="{{ asset('storage/' . $course->thumbnail_path) }}" alt="{{ $course->name }}" class="w-full h-64 object-cover rounded-lg mb-4">
                        @endif
                        <h1 class="text-3xl font-bold mb-2">{{ $course->name }}</h1>
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <span class="text-gray-600">Instructor:</span>
                                <span class="ml-2 font-semibold">{{ $course->instructor->name }}</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-gray-600">Rating:</span>
                                <span class="ml-2 font-semibold">{{ number_format($averageRating, 1) }} / 5.0</span>
                            </div>
                        </div>
                    </div>

                    <!-- Course Description -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold mb-4">Description</h2>
                        <p class="text-gray-700">{{ $course->description }}</p>
                    </div>

                    <!-- Enrollment Section -->
                    @auth
                        @if(auth()->user()->isStudent())
                            @if(!auth()->user()->enrolledCourses->contains($course->id))
                                <form action="{{ route('courses.enroll', $course) }}" method="POST" class="mb-8">
                                    @csrf
                                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                                        Enroll Now
                                    </button>
                                </form>
                            @else
                                <div class="mb-8">
                                    <span class="text-green-600 font-semibold">You are enrolled in this course</span>
                                </div>
                            @endif
                        @endif
                    @endauth

                    <!-- Reviews Section -->
                    <div>
                        <h2 class="text-xl font-semibold mb-4">Reviews</h2>
                        @auth
                            @if(auth()->user()->isStudent() && auth()->user()->enrolledCourses->contains($course->id))
                                <form action="{{ route('courses.review', $course) }}" method="POST" class="mb-6">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="rating" class="block text-sm font-medium text-gray-700">Rating</label>
                                        <select name="rating" id="rating" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            <option value="5">5 - Excellent</option>
                                            <option value="4">4 - Very Good</option>
                                            <option value="3">3 - Good</option>
                                            <option value="2">2 - Fair</option>
                                            <option value="1">1 - Poor</option>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label for="comment" class="block text-sm font-medium text-gray-700">Comment</label>
                                        <textarea name="comment" id="comment" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                                    </div>
                                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                                        Submit Review
                                    </button>
                                </form>
                            @endif
                        @endauth

                        <div class="space-y-4">
                            @forelse($course->reviews as $review)
                                <div class="border rounded-lg p-4">
                                    <div class="flex justify-between mb-2">
                                        <div>
                                            <span class="font-semibold">{{ $review->user->name }}</span>
                                            <span class="text-gray-500 text-sm ml-2">{{ $review->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="text-yellow-500">
                                            {{ $review->rating }}/5
                                        </div>
                                    </div>
                                    <p class="text-gray-700">{{ $review->comment }}</p>
                                </div>
                            @empty
                                <p class="text-gray-500">No reviews yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
