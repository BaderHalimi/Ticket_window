@extends('visitor.layouts.app')
@section('title', 'Events - ')

@push('styles')
<style>
    body {
        font-family: 'Quicksand', sans-serif;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(87, 181, 231, 0.05) 50%, rgba(177, 156, 217, 0.1) 100%);
        min-height: 100vh;
    }

    h1, h2, h3, h4, h5, h6 {
        font-family: 'Space Grotesk', sans-serif;
    }

    .glassmorphism {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
    }

    .card-hover:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 15px 30px rgba(87, 181, 231, 0.1);
    }
</style>
@endpush

@section('sub_content')

<div class="max-w-6xl mx-auto py-10">
    <h2 class="text-3xl font-bold text-indigo-900 mb-8">Upcoming Events</h2>

    <div class="space-y-6">
        @foreach($events as $event)
        <div class="glassmorphism p-4 rounded-xl transition-all duration-300 card-hover flex flex-col sm:flex-row items-center sm:items-start gap-6">
            
            <img src="{{ $event->image_url ?? 'https://via.placeholder.com/200x150' }}" alt="Event Image"
                 class="w-full sm:w-60 h-40 object-cover rounded-lg border border-gray-200">

            <div class="flex-1 w-full">
                <h3 class="text-xl font-semibold text-indigo-800">{{ $event->name }}</h3>
                <p class="text-sm text-gray-600 mt-1">{{ $event->date }} • {{ $event->time }} • {{ $event->venue }}</p>
                <p class="text-sm text-gray-700 mt-3 line-clamp-3">{{ $event->description }}</p>

                <div class="mt-4">
                    <a href="{{ route('visitor.event_details', $event->id) }}"
                       class="inline-flex items-center gap-1 px-4 py-2 bg-indigo-600 text-white text-sm rounded-full hover:bg-indigo-700 transition">
                        <i class="ri-eye-line ri-sm"></i> View Details
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
