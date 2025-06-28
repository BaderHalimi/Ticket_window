@extends('admin.layouts.app')

@section('content')
<div class="p-6 md:p-10 max-w-7xl mx-auto">
    
    {{-- Header --}}
    <div class="flex items-center justify-between mb-10">
        <div>
            <h1 class="text-4xl font-extrabold text-orange-600 flex items-center gap-3">
                <svg class="w-10 h-10 text-orange-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z" />
                </svg>
                تفاصيل طلب السحب
            </h1>
            <p class="text-slate-500 mt-1">رقم الطلب: <span class="font-mono bg-slate-100 rounded px-2 py-0.5 text-orange-600">{{ $log->withdraw_id }}</span></p>
        </div>
        <div class="bg-orange-50 px-6 py-3 rounded-xl shadow-inner ring-2 ring-orange-300">
            <div class="text-lg font-bold text-orange-700">الإجمالي المطلوب:</div>
            <div class="text-3xl font-extrabold">{{ number_format($log->amount, 2) }} ريال</div>
            <div class="text-sm text-slate-400 mt-1">الحالة: 
                @if($log->status === 'pending')
                    <span class="inline-block px-2 py-0.5 rounded-full bg-yellow-100 text-yellow-800">قيد المراجعة</span>
                @elseif($log->status === 'completed')
                    <span class="inline-block px-2 py-0.5 rounded-full bg-green-100 text-green-800">مكتمل</span>
                @else
                    <span class="inline-block px-2 py-0.5 rounded-full bg-red-100 text-red-800">مرفوض</span>
                @endif
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto bg-white rounded-3xl shadow-2xl ring-2 ring-orange-200">
        <table class="min-w-full text-sm text-slate-800">
            <thead class="bg-gradient-to-r from-orange-400 to-orange-600 text-white">
                <tr class="text-center">
                    <th class="px-4 py-3">الكود</th>
                    <th class="px-4 py-3">الخدمة</th>
                    <th class="px-4 py-3">التاجر</th>
                    <th class="px-4 py-3">العميل</th>
                    <th class="px-4 py-3">السعر</th>
                    <th class="px-4 py-3">التاريخ والوقت</th>
                    <th class="px-4 py-3">حالة الدفع</th>
                    <th class="px-4 py-3">ملاحظات إضافية</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-orange-100">
                @forelse($transactions as $transaction)
                    @php
                        $item = $transaction->item;
                        $merchant = $item->user ?? null;
                        $customer = $transaction->user ?? null;
                        $additional = $transaction->additional_data ?? [];
                    @endphp

                    <tr class="hover:bg-orange-50 transition duration-300 ease-in-out">
                        {{-- Transaction Code --}}
                        <td class="px-4 py-4 font-mono text-xs text-orange-700 bg-orange-50">
                            <div class="flex flex-col items-center gap-1">
                                <span class="font-bold">{{ $transaction->transaction_id }}</span>
                                <span class="text-slate-400 text-xs">{{ $transaction->created_at->format('Y-m-d') }}</span>
                            </div>
                        </td>

                        {{-- Service --}}
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-4">
                                @if($item && $item->image)
                                    <a href="{{route('template1.index',$item->id)}}"> <img src="{{ asset('storage/' . $item->image) }}" class="w-16 h-16 rounded-xl object-cover ring-2 ring-orange-300 shadow-lg hover:scale-105 transition"></a>
                                @else
                                    <div class="w-16 h-16 bg-orange-100 rounded-xl flex items-center justify-center text-orange-600 font-bold">؟</div>
                                @endif
                                {{-- <div>
                                    <div class="font-semibold text-lg">{{ $item->name ?? '—' }}</div>
                                    <div class="text-xs text-slate-400">ID: {{ $item->id ?? '—' }}</div>
                                </div> --}}
                            </div>
                        </td>

                        {{-- Merchant --}}
                        <td class="px-4 py-4 text-center">
                            <div class="flex flex-col items-center gap-2">
                                @if($merchant && ($merchant->additional_data['profile_image'] ?? null))
                                    <img src="{{ asset('storage/' . $merchant->additional_data['profile_image']) }}" class="w-10 h-10 rounded-full object-cover ring-2 ring-orange-300 shadow">
                                @else
                                    <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center text-orange-600 font-bold">ت</div>
                                @endif
                                <div class="text-sm font-semibold">{{ $merchant->f_name ?? '—' }}</div>
                                <div class="text-xs text-slate-400">{{ $merchant->email ?? '—' }}</div>
                            </div>
                        </td>

                        {{-- Customer --}}
                        <td class="px-4 py-4 text-center">
                            <div class="flex flex-col items-center gap-2">
                                @if($customer && ($customer->additional_data['profile_image'] ?? null))
                                    <img src="{{ asset('storage/' . $customer->additional_data['profile_image']) }}" class="w-10 h-10 rounded-full object-cover ring-2 ring-orange-300 shadow">
                                @else
                                    <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center text-orange-600 font-bold">ع</div>
                                @endif
                                <div class="text-sm font-semibold">{{ $customer->f_name ?? '—' }}</div>
                                <div class="text-xs text-slate-400">{{ $customer->email ?? '—' }}</div>
                            </div>
                        </td>

                        {{-- Amount --}}
                        <td class="px-4 py-4 font-bold text-orange-700 text-center">
                            {{ number_format($transaction->amount, 2) }} <span class="text-xs text-slate-400">ريال</span>
                        </td>

                        {{-- Date / Time --}}
                        <td class="px-4 py-4 text-slate-600 text-center">
                            <div class="font-semibold">{{ $additional['selected_date'] ?? '—' }}</div>
                            <div class="text-xs text-slate-400">{{ $additional['selected_time'] ?? '—' }}</div>
                        </td>

                        {{-- Payment Status --}}
                        <td class="px-4 py-4 text-center">
                            @if(($additional['type'] ?? '') === 'pay')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-green-100 text-green-800 text-xs font-semibold">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg> دفع
                                </span>
                            @elseif(($additional['type'] ?? '') === 'refund')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-red-100 text-red-800 text-xs font-semibold">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg> إرجاع
                                </span>
                            @else
                                <span class="inline-block px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 text-xs font-semibold">غير محدد</span>
                            @endif
                        </td>

                        {{-- Extra Note --}}
                        <td class="px-4 py-4 text-slate-500 text-center text-xs">
                            {{ $additional['notes'] ?? '—' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-8 text-slate-500">لا توجد معاملات مسجلة ضمن هذا الطلب.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
