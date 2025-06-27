@extends('merchant.layouts.app')

@section('content')
<div class="flex-1 p-8">
    <div class="space-y-6">
        <h2 class="text-3xl font-bold text-slate-800">إدارة الحجوزات</h2>

        <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg">
            <div class="px-4 py-2">
                <table class="w-full caption-bottom text-sm">
                    <thead>
                        <tr class="border-b">
                            <th class="h-12 px-4 text-right">العميل</th>
                            <th class="h-12 px-4 text-right">رقم الهاتف</th> <!-- إضافة رقم الهاتف -->
                            <th class="h-12 px-4 text-right">الخدمة</th>
                            <th class="h-12 px-4 text-right">الحالة</th>
                            <th class="h-12 px-4 text-right">المبلغ المدفوع</th> <!-- عرض المبلغ المدفوع -->
                            <th class="h-12 px-4 text-right">التاريخ</th>
                            <th class="h-12 px-4 text-center">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $reservation)
                            <tr>
                                <td class="p-4">
                                    <!-- عرض اسم العميل من الـ User -->
                                    <div class="flex items-center gap-3">
                                        {{-- <span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full">
                                            <span class="flex h-full w-full items-center justify-center rounded-full bg-muted">{{ $reservation->user->l_name }}</span>
                                        </span> --}}
                                        <div>
                                            <div class="font-semibold">{{ $reservation->user->f_name ?? 'non ' }}</div>
                                            {{-- <div class="text-xs text-slate-500 font-mono">{{ $reservation->user->id }}</div> --}}
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <!-- عرض رقم الهاتف الخاص بالعميل إذا كان موجودًا -->
                                    {{ $reservation->user->phone ?? 'غير متوفر' }}
                                </td>
                                <td class="p-4">{{ $reservation->item->name }}</td>
                                <td class="p-4">
                                    @if($reservation->additional_data['type'] ?? 1  == 'pay')
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">دفع</span>
                                    @elseif($reservation->additional_data['type'] ?? 1 == 'refund')
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">الغاء</span>
                                    {{-- @else
                                         <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">معلق</span> ---}}
                                    @endif 
                                </td>
                                <td class="p-4">
                                    <!-- عرض المبلغ المدفوع -->
                                    {{ $reservation->amount }} 
                                </td>
                                <td class="p-4">{{ $reservation->created_at->format('Y-m-d') }}</td>
                                <td class="p-4 text-center">
                                    <a href="{{route("merchant.dashboard.reservations.show",$reservation->id)}}" class="text-blue-500 hover:underline">عرض التفاصيل</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
