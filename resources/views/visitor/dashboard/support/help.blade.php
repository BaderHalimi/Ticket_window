@extends('seller.layouts.app')
@section('title', 'Dashboard - تعبئة النموذج')

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
</style>
@endpush

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-12">
    <form action="{{route("visitor.support.store")}}" method="POST" class="glassmorphism p-8 rounded-lg shadow-md w-full max-w-lg card-hover">
        @csrf
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">نموذج تعبئة</h2>

        <div class="mb-4">
            <label for="name" class="block mb-2 font-medium text-gray-700">الاسم</label>
            <input type="text" name="name" id="name" placeholder="أدخل الاسم" required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" />
        </div>

        <div class="mb-4">
            <label for="email" class="block mb-2 font-medium text-gray-700">البريد الإلكتروني</label>
            <input type="email" name="email" id="email" placeholder="example@example.com" required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" />
        </div>

        <div class="mb-4">
            <label for="message" class="block mb-2 font-medium text-gray-700">الرسالة</label>
            <textarea name="message" id="message" rows="4" placeholder="أدخل رسالتك"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition resize-none"></textarea>
        </div>

        <button type="submit"
            class="w-full bg-indigo-600 text-white py-3 rounded-md font-semibold hover:bg-indigo-700 transition">إرسال</button>
    </form>
</div>
@endsection
