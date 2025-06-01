@extends('visitor.layouts.app')
@section('title', 'Event Details - ')

@push('styles')
<style>
    body {
        font-family: 'Quicksand', sans-serif;
        background: linear-gradient(135deg, #f0f9ff 0%, #e6e6fa 100%);
        min-height: 100vh;
    }

    h1, h2, h3, h4, h5, h6 {
        font-family: 'Space Grotesk', sans-serif;
    }

    .glassmorphism {
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        box-shadow: 0 12px 32px rgba(106, 90, 205, 0.1);
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
<div class="max-w-5xl mx-auto py-12">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Event Details</h1>
        <a href="{{ route('visitor.my_events') }}" class="gradient-button text-white px-4 py-2 rounded-lg shadow-md">
            <i class="ri-arrow-left-line"></i> Back to Events
        </a>
    </div>

    <div class="glassmorphism p-10 rounded-lg shadow-lg grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <img src="{{ Storage::url($event->image) }}" alt="Event Image" class="rounded-lg shadow-lg w-full h-auto object-cover">
        </div>
        <div>
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">{{ $event->name }}</h2>
            <p class="text-gray-600 mb-2"><strong>Date:</strong> {{ $event->date->format('F d, Y h:i A') }}</p>
            <p class="text-gray-600 mb-2"><strong>Location:</strong> {{ $event->location }}</p>
            <p class="text-gray-600 mb-2"><strong>Total Tickets:</strong> {{ $event->total_tickets }}</p>
            <p class="text-gray-600 mb-2"><strong>Ticket Price:</strong> SAR {{ number_format($event->ticket_price, 2) }}</p>
            <p class="text-gray-600 mb-4"><strong>Status:</strong> 
                <span class="{{ $event->status === 'active' ? 'text-green-600' : 'text-red-600' }}">
                    {{ ucfirst($event->status) }}
                </span>
            </p>
        </div>
        <div class="col-span-2">
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Description</h3>
            <p class="text-gray-700">{{ $event->description }}</p>
        </div>
        <div class="col-span-2">
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Description</h3>
            <p class="text-gray-700 mb-6">{{ $event->description }}</p>
        
            <div class="text-right">
                <a href="" 
                   class="gradient-button text-white px-6 py-3 rounded-lg shadow-lg text-lg font-semibold inline-flex items-center">
                    <i class="ri-ticket-line mr-2"></i> احجز الآن
                </a>
            </div>
        </div>
        
    </div>
</div>
@endsection
