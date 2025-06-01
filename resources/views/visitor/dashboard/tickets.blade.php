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
            <div class="flex items-center space-x-4">
                <div class="bg-indigo-100 rounded-full flex items-center justify-center">
                    <img src="{{ Storage::url($ticket->event->image) }}" alt="{{ $ticket->event->name }}" class="h-20 w-full rounded-md object-cover">
                </div>
                <div>
                    <h3 class="text-xl font-semibold">{{ $ticket->event->name }}</h3>
                    <p class="text-sm text-gray-600">{{ $ticket->event->date->format('d-m-Y') }} • {{ $ticket->event->date->format('h:i A') }}</p>
                    <p class="text-sm text-gray-600">{{ $ticket->venue }}</p>
                    <p class="text-sm text-gray-600"><span>Ticket Code:</span> <span class="font-bold @if($ticket->status == 'paid') text-green-400 @elseif($ticket->status == 'cancled') text-red-400 @else text-blue-400 @endif">{{ $ticket->code }}</span></p>
                </div>
            </div>

            <div class="flex flex-col items-end space-y-2">
                @if($ticket->status == 'pending')
                    <form action="{{ route('visitor.tickets.update',['ticket'=>$ticket->id]) }}" method="post">@csrf <button class="bg-green-600 border border-green-600 px-3 py-1 rounded-md mt-2 transition duration-50 text-white hover:bg-white hover:text-green-600">checkout</button></form></span> <span>
                        <form action="{{ route('visitor.tickets.destroy',['ticket'=>$ticket->id]) }}" method="post"> @csrf @method('delete') <button type="submit" class="bg-red-600 border border-red-600 px-3 py-1 rounded-md mt-2 transition duration-50 text-white hover:bg-white hover:text-red-600">delete ticket</button></form>
                    </span>
                @elseif($ticket->status == 'paid')
                <a href="" class="flex items-center gap-1 bg-white hover:bg-gray-600 hover:border-gray-600 hover:text-white px-4 py-2 rounded-full border border-gray-200 text-sm transition duration-50">
                    <i class="ri-qr-code-line ri-sm"></i> View QR
                </a>

                <a href="" class="flex items-center gap-1 bg-white hover:bg-gray-600 hover:border-gray-600 hover:text-white px-4 py-2 rounded-full border border-gray-200 text-sm transition duration-50">
                    <i class="ri-file-pdf-line ri-sm"></i> Download PDF
                </a>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
