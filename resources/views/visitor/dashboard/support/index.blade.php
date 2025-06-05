@extends('seller.layouts.app')
@section('title', 'Dashboard - ')

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

    .card-hover:hover {
        transform: translateY(-5px) scale(1.01);
        box-shadow: 0 20px 40px rgba(106, 90, 205, 0.15);
    }

    .gradient-button {
        background: linear-gradient(to right, #6a5acd, #8a2be2);
        color: white;
        padding: 0.5rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 14px rgba(106, 90, 205, 0.3);
    }

    .gradient-button:hover {
        background: linear-gradient(to right, #8a2be2, #6a5acd);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(106, 90, 205, 0.4);
    }
</style>
@endpush

@section('sub_content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-semibold text-gray-800">تذاكرك</h1>
        <a href="{{ route('visitor.support.create') }}" class="gradient-button">
            + إضافة تذكرة جديدة
        </a>
    </div>

    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse($tickets as $ticket)
            <div class="glassmorphism rounded-xl p-6 shadow-md card-hover transition duration-300 cursor-pointer">
                <h2 class="text-xl font-bold mb-2 text-indigo-700">{{ $ticket->title ?? 'بدون عنوان' }}</h2>
                <p class="text-gray-700 mb-4">{{  \Illuminate\Support\Str::limit($ticket->content,30) ?? 'لا يوجد وصف' }}</p>

                <div class="text-sm text-gray-500 mb-2">
                    <span class="font-semibold">البريد الإلكتروني:</span>
                    {{ $ticket->user->email ?? 'غير متوفر' }}
                </div>

                <div class="text-sm text-gray-400">
                    <span class="font-semibold">تاريخ الإنشاء:</span>
                    {{ \Carbon\Carbon::parse($ticket->created_at)->diffForHumans() }}
                </div>
            </div>
        @empty
            <p class="col-span-full text-center text-gray-500">لا توجد تذاكر لعرضها</p>
        @endforelse
    </div>
</div>
@endsection
