@extends('visitor.layouts.app')
@section('title', 'My Tickets - ')

@push('styles')
<style>
    body {
        font-family: 'Quicksand', sans-serif;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(87, 181, 231, 0.05) 50%, rgba(177, 156, 217, 0.1) 100%);
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

<div class="max-w-5xl mx-auto py-10">
    <h2 class="text-3xl font-bold text-indigo-900 mb-8">My Tickets</h2>

    <div class="space-y-6">
        <!-- Ticket Card -->
        @foreach($tickets as $ticket)
        <div class="glassmorphism p-6 rounded-xl transition-all duration-300 card-hover flex justify-between items-center">
            <div>
                <h3 class="text-xl font-semibold">{{ $ticket->event_name }}</h3>
                <p class="text-sm text-gray-600">{{ $ticket->event_date }} • {{ $ticket->event_time }}</p>
                <p class="text-sm text-gray-600">{{ $ticket->venue }}</p>
                <p class="text-sm text-gray-600">Ticket Code: <span class="font-bold">{{ $ticket->ticket_code }}</span></p>
            </div>

            <div class="flex flex-col items-end space-y-2">
                <a href="{{ route('visitor.view_qr', $ticket->id) }}" class="flex items-center gap-1 bg-white px-4 py-2 rounded-full border border-gray-200 text-sm">
                    <i class="ri-qr-code-line ri-sm"></i> View QR
                </a>

                <a href="{{ route('visitor.download_pdf', $ticket->id) }}" class="flex items-center gap-1 bg-white px-4 py-2 rounded-full border border-gray-200 text-sm">
                    <i class="ri-file-pdf-line ri-sm"></i> Download PDF
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
