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
</style>
@endpush

@section('sub_content')
<div class="max-w-7xl mx-auto py-12">
    <h2 class="text-3xl font-bold text-indigo-900 mb-8 text-center">قائمة المبيعات</h2>

    <div class="glassmorphism p-6 rounded-3xl overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-right">
            <thead>
                <tr class="text-gray-700 bg-white bg-opacity-60">
                    <th class="px-6 py-3 text-sm font-semibold">اسم العرض</th>
                    <th class="px-6 py-3 text-sm font-semibold">المشتري</th>
                    <th class="px-6 py-3 text-sm font-semibold">السعر</th>
                    <th class="px-6 py-3 text-sm font-semibold">التاريخ</th>
                    <th class="px-6 py-3 text-sm font-semibold">الحالة</th>
                    <th class="px-6 py-3 text-sm font-semibold">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="bg-white bg-opacity-40 divide-y divide-gray-200">

                @foreach($tickets as $ticket)
    <tr>
        {{-- اسم العرض (event name from additional_data) --}}
        <td class="px-6 py-4">
            {{ $ticket->additional_data['event_name'] ?? '-' }}
        </td>

        {{-- اسم المشتري --}}
        <td class="px-6 py-4">{{ $ticket->user->name ?? 'مستخدم مجهول' }}</td>

        {{-- السعر --}}
        <td class="px-6 py-4 text-green-600 font-bold">${{ number_format($ticket->price, 2) }}</td>

        {{-- التاريخ --}}
        <td class="px-6 py-4">{{ $ticket->created_at->format('Y-m-d') }}</td>

        {{-- الحالة --}}
        <td class="px-6 py-4">
            @if($ticket->status == 'paid')
                <span class="text-green-700 font-medium">تم الدفع</span>
            @elseif($ticket->status == 'pending')
                <span class="text-yellow-600 font-medium">قيد الانتظار</span>
            @elseif($ticket->status == 'canceled')
                <span class="text-red-600 font-medium">ملغاة</span>
            @else
                <span class="text-gray-600 font-medium">{{ $ticket->status }}</span>
            @endif
        </td>

        {{-- الإجراءات --}}
        <td class="px-6 py-4 space-x-2 space-x-reverse">
            <button class="text-blue-700 hover:bg-blue-700 rounded-full px-3 py-2 hover:text-white transition duration-500" title="عرض">
                <i class="ri-eye-line text-lg"></i>
            </button>

            <button class="text-gray-700 hover:bg-gray-700 rounded-full px-3 py-2 hover:text-white transition duration-500" title="طباعة">
                <i class="ri-printer-line text-lg"></i>
            </button>
        </td>
    </tr>
@endforeach

            
            </tbody>
            
        </table>
    </div>
</div>

@endsection
