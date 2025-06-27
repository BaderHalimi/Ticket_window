@extends('merchant.layouts.app')

@section('content')
<div class="flex-1 p-6 md:p-10 bg-orange-50 min-h-screen">

    <!-- Back button -->
    <div class="mb-6">
        <a href="{{ route('merchant.dashboard.reservations.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold shadow-md transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-lg">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            رجوع
        </a>
    </div>

    <!-- Main Card -->
    <div class="max-w-4xl mx-auto bg-white border-4 border-orange-400 rounded-3xl shadow-2xl p-8 space-y-10 transition-all duration-500 hover:shadow-orange-300">

        <!-- Header -->
        <div class="text-center space-y-3">
            <h2 class="text-4xl font-extrabold text-orange-700 animate-pulse">ملف حجز العميل</h2>
            <p class="text-slate-500">جميع التفاصيل مرتبة بشكل واضح للتاجر</p>
        </div>

        <!-- User Section -->
        <div class="flex flex-col md:flex-row items-center gap-8 border-b border-orange-200 pb-8">
            <div class="relative">
                @php
                $userImage = $reservation->user->additional_data["profile_image"] ?? null;
            @endphp
            
            @if($userImage)
                <img src="{{ asset('storage/' . $userImage) }}" alt="User Image"
                     class="w-40 h-40 rounded-full object-cover shadow-lg ring-4 ring-orange-300 transition duration-300 hover:scale-105">
            @else
                <div class="w-40 h-40 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 text-6xl font-bold shadow-lg ring-4 ring-orange-300">
                    {{ mb_substr($reservation->user->f_name ?? '؟', 0, 1) }}
                </div>
            @endif
            
            </div>
            <div class="flex-1 space-y-2">
                <h3 class="text-3xl font-bold text-orange-800">{{ $reservation->user->f_name ?? 'غير متوفر' }}</h3>
                <p class="text-slate-500">رقم الهاتف: {{ $reservation->user->phone ?? 'غير متوفر' }}</p>
                <p class="text-slate-500">الإيميل: {{ $reservation->user->email ?? 'غير متوفر' }}</p>
            </div>
        </div>

        <!-- Service Section -->
        <div class="space-y-4 border-b border-orange-200 pb-8">
            <h4 class="text-2xl font-bold text-orange-700 border-b-2 border-orange-300 inline-block pb-1">معلومات الخدمة</h4>
            <div class="flex flex-col md:flex-row gap-6">
                @if($reservation->item->image ?? null)
                <img src="{{ asset('storage/' . $reservation->item->image) }}" alt="Service Image" class="w-full md:w-64 h-40 object-cover rounded-xl shadow-md ring-2 ring-orange-200">
                @endif
                <div class="flex-1 space-y-2 text-slate-700">
                    <p><span class="font-semibold text-orange-600">اسم الخدمة:</span> {{ $reservation->item->name ?? 'غير متوفر' }}</p>
                    <p><span class="font-semibold text-orange-600">وصف:</span> {{ $reservation->item->description ?? 'لا يوجد وصف متاح' }}</p>
                    <p><span class="font-semibold text-orange-600">المدة:</span> {{ $reservation->item->duration ?? 'غير محدد' }}</p>
                    <p><span class="font-semibold text-orange-600">السعر الأساسي:</span> {{ $reservation->item->price ?? 'غير متوفر' }}</p>

                    @php
                        $features = $reservation->item->features ?? [];
                    @endphp

                    @if($features)
                        <div class="space-y-1 mt-4">
                            <p class="text-orange-600 font-semibold">تفاصيل إضافية:</p>
                            <p>المدة المحجوزة: {{ $features['booking_duration'] ?? 'غير محددة' }} دقيقة</p>
                            <p>الحد الأقصى للمستخدمين: {{ $features['user_limit'] ?? 'غير متوفر' }}</p>
                            <p>السعر الأساسي: {{ $features['base_price'] ?? 'غير متوفر' }}</p>

                            @if(!empty($features['pricing_packages']))
                                <div>
                                    <p class="font-semibold text-orange-600">الباقات:</p>
                                    <ul class="list-disc list-inside text-slate-600">
                                        @foreach($features['pricing_packages'] as $package)
                                            <li>{{ $package['label'] ?? 'بلا اسم' }} - {{ $package['price'] ?? '0' }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if(!empty($features['work_schedule']))
                                <div>
                                    <p class="font-semibold text-orange-600">مواعيد العمل:</p>
                                    <ul class="list-disc list-inside text-slate-600">
                                        @foreach($features['work_schedule'] as $day => $schedule)
                                            @if($schedule['enabled'])
                                                <li>{{ ucfirst($day) }}: {{ $schedule['start'] ?? '?' }} - {{ $schedule['end'] ?? '?' }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Reservation Section -->
        <div class="space-y-4">
            <h4 class="text-2xl font-bold text-orange-700 border-b-2 border-orange-300 inline-block pb-1">معلومات الحجز</h4>
            <div class="text-slate-700 space-y-2">
                <p><span class="font-semibold text-orange-600">رقم الحجز:</span> {{ $reservation->id ?? '#' }}</p>
                <p><span class="font-semibold text-orange-600">المبلغ المدفوع:</span> {{ $reservation->amount ?? '0.00' }}</p>
                <p><span class="font-semibold text-orange-600">تاريخ الإنشاء:</span> {{ $reservation->created_at->format('Y-m-d') ?? 'غير متوفر' }}</p>

                <p class="flex items-center gap-2">
                    <span class="font-semibold text-orange-600">الحالة:</span>
                    @if(($reservation->additional_data['type'] ?? 1) == 'pay')
                        <span class="inline-block px-3 py-1 rounded-full bg-green-100 text-green-800 font-semibold shadow-sm transition duration-300 hover:bg-green-200">دفع</span>
                    @elseif(($reservation->additional_data['type'] ?? 1) == 'refund')
                        <span class="inline-block px-3 py-1 rounded-full bg-red-100 text-red-800 font-semibold shadow-sm transition duration-300 hover:bg-red-200">إلغاء</span>
                    @else
                        <span class="inline-block px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 font-semibold shadow-sm transition duration-300 hover:bg-yellow-200">معلق</span>
                    @endif
                </p>

                @php
                    $additional = $reservation->additional_data ?? [];
                @endphp

                <p><span class="font-semibold text-orange-600">التاريخ المحجوز:</span> {{ $additional['selected_date'] ?? 'غير محدد' }}</p>
                <p><span class="font-semibold text-orange-600">الوقت المحجوز:</span> {{ $additional['selected_time'] ?? 'غير محدد' }}</p>
                <p><span class="font-semibold text-orange-600">كوبون الخصم:</span> {{ $additional['coupon_code'] ?: 'لا يوجد' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
