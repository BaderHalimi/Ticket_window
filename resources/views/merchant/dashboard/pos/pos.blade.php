@extends('merchant.layouts.app')

@section('content')
<div class="container mx-auto p-4">

    {{-- زر إضافة POS جديد --}}
    <div class="flex justify-end mb-6">
        <a href="{{ route('merchant.dashboard.pos.create') }}"
           class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded-lg font-bold shadow-md transition duration-300">
            + إضافة POS جديد
        </a>
    </div>

    {{-- جدول الحجوزات --}}
    <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-100">
                <tr>
                    <th class="px-4 py-3 text-right text-xs font-bold text-slate-600 uppercase tracking-wider">#</th>
                    <th class="px-4 py-3 text-right text-xs font-bold text-slate-600 uppercase tracking-wider">الكود</th>
                    <th class="px-4 py-3 text-right text-xs font-bold text-slate-600 uppercase tracking-wider">عدد التذاكر</th>
                    <th class="px-4 py-3 text-right text-xs font-bold text-slate-600 uppercase tracking-wider">السعر</th>
                    <th class="px-4 py-3 text-right text-xs font-bold text-slate-600 uppercase tracking-wider">طريقة الدفع</th>
                    <th class="px-4 py-3 text-right text-xs font-bold text-slate-600 uppercase tracking-wider">التاريخ</th>
                    <th class="px-4 py-3 text-right text-xs font-bold text-slate-600 uppercase tracking-wider">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
                @forelse($reservations as $index => $reservation)
                @php
                    $data = json_decode($reservation->additional_data, true);
                @endphp
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-4 py-3 text-sm">{{ $index + 1 }}</td>
                    <td class="px-4 py-3 text-sm font-mono text-slate-700">{{ $reservation->code }}</td>
                    <td class="px-4 py-3 text-sm">{{ $reservation->quantity }}</td>
                    <td class="px-4 py-3 text-sm text-green-600 font-bold">{{ $reservation->price }} ريال</td>
                    <td class="px-4 py-3 text-sm">
                        <span class="inline-block bg-slate-100 text-slate-700 px-2 py-1 rounded">
                            {{ $data['paymentMethod'] ?? '-' }}
                        </span>
                    </td>
                    @if ($reservation->status == 'pending')
                        
                    @endif
                    <td class="px-4 py-3 text-sm text-slate-500">{{ $data['selected_time'] ?? NULL }} / {{ $data['selected_day'] ?? NULL }}</td>
                    <td class="px-4 py-3 text-sm">
                        <div class="flex items-center space-x-2 space-x-reverse">
                            <a href="{{ route('merchant.dashboard.pos.show', $reservation->id) }}"
                               class="text-orange-500 hover:text-orange-600 font-bold transition duration-200">
                                عرض
                            </a>
                            <span class="text-slate-400">/</span>
                            <form action="{{ route('merchant.dashboard.pos.destroy', $reservation->id) }}" method="POST" class="inline">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="text-red-500 hover:text-red-600 font-bold focus:outline-none">
                                    حذف
                                </button>
                            </form>
                        </div>
                    </td>
                    
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-6 text-slate-500">
                        لا توجد حجوزات POS حالياً
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
