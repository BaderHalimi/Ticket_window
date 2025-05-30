@extends('seller.layouts.app')
@section('title', 'Dashboard - ')

@push('styles')
<style>
    body {
        font-family: 'Quicksand', sans-serif;
        background: linear-gradient(135deg, #f0f9ff 0%, #e6e6fa 100%);
        min-height: 100vh;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-family: 'Space Grotesk', sans-serif;
    }

    .glassmorphism {
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        box-shadow: 0 12px 32px rgba(106, 90, 205, 0.1);
    }

    .card-hover:hover {
        transform: translateY(-5px) scale(1.01);
        box-shadow: 0 20px 40px rgba(106, 90, 205, 0.15);
    }

    .gradient-button {
        background: linear-gradient(135deg, #57B5E7 0%, #B19CD9 100%);
        transition: all 0.3s ease;
    }

    .gradient-button:hover {
        background: linear-gradient(135deg, #4da8d9 0%, #a28cc7 100%);
        transform: translateY(-2px);
    }
</style>
@endpush

@section('sub_content')

<div class="max-w-7xl mx-auto py-12">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Events</h1>
        <a href="{{ route('seller.events.create') }}" class="gradient-button text-white px-4 py-2 rounded-lg shadow-md">
            <i class="ri-add-line"></i> Create Event
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($events as $event)
            <div class="card-hover glassmorphism p-6 rounded-lg shadow-lg transition-transform">
                <h2 class="text-xl font-semibold text-gray-800">{{ $event->name }}</h2>
                <p class="text-gray-600 mt-2">{{ $event->description }}</p>
                <p class="text-gray-500 mt-1">Date: {{ $event->date }}</p>
                <p class="text-gray-500 mt-1">Location: {{ $event->location }}</p>
                <div class="mt-4 flex justify-between items-center">
                    <a href="{{ route('seller.events.edit', $event->id) }}" class="text-blue-600 hover:underline">Edit</a>
                    <form action="{{ route('seller.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this event?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

</div>

@endsection