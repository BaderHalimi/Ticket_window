@extends('visitor.layouts.app')
@section('title', 'My Bookings - ')

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
    .status-confirmed {
        background-color: rgba(34, 197, 94, 0.2);
        color: rgb(34, 197, 94);
    }
    .status-pending {
        background-color: rgba(234, 179, 8, 0.2);
        color: rgb(234, 179, 8);
    }
    .status-canceled {
        background-color: rgba(239, 68, 68, 0.2);
        color: rgb(239, 68, 68);
    }
</style>
@endpush

@section('sub_content')

<div class="max-w-5xl mx-auto py-10">
    <h2 class="text-3xl font-bold text-indigo-900 mb-8">My Bookings</h2>

    <div class="space-y-6">
        <!-- Booking Card -->
        @foreach($bookings as $booking)
        <div class="glassmorphism p-6 rounded-xl transition-all duration-300 card-hover flex justify-between items-center">
            <div>
                <h3 class="text-xl font-semibold">{{ $booking->event_name }}</h3>
                <p class="text-sm text-gray-600">{{ $booking->event_date }} • {{ $booking->event_time }}</p>
                <p class="text-sm text-gray-600">{{ $booking->venue }}</p>
            </div>
            <div class="flex flex-col items-end">
                <span class="px-4 py-1 rounded-full text-sm font-medium
                    @if($booking->status == 'confirmed') status-confirmed
                    @elseif($booking->status == 'pending') status-pending
                    @else status-canceled @endif">
                    {{ ucfirst($booking->status) }}
                </span>

                <div class="flex mt-4 space-x-2">
                    <a href="{{ route('visitor.view_qr', $booking->id) }}" class="flex items-center gap-1 bg-white px-3 py-1.5 rounded-full border border-gray-200 text-sm">
                        <i class="ri-qr-code-line ri-sm"></i> View QR
                    </a>
                    <a href="{{ route('visitor.download_pdf', $booking->id) }}" class="flex items-center gap-1 bg-white px-3 py-1.5 rounded-full border border-gray-200 text-sm">
                        <i class="ri-file-pdf-line ri-sm"></i> PDF
                    </a>
                    @if($booking->status == 'pending')
                    <a href="{{ route('visitor.pay_now', $booking->id) }}" class="flex items-center gap-1 bg-white px-3 py-1.5 rounded-full border border-gray-200 text-sm">
                        <i class="ri-bank-card-line ri-sm"></i> Pay Now
                    </a>
                    @endif
                    @if($booking->status == 'canceled')
                    <a href="{{ route('visitor.rebook', $booking->id) }}" class="flex items-center gap-1 bg-white px-3 py-1.5 rounded-full border border-gray-200 text-sm">
                        <i class="ri-refresh-line ri-sm"></i> Rebook
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
