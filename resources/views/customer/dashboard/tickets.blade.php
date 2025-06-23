@extends('customer.layouts.app')
@section('content')
<div bis_skin_checked="1" style="opacity: 1; transform: none;">
    <div class="space-y-6" bis_skin_checked="1">
        <div bis_skin_checked="1">
            <h1 class="text-3xl font-bold text-slate-800">حجوزاتي</h1>
            <p class="text-slate-500 mt-1">جميع حجوزاتك السابقة والقادمة.</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg" bis_skin_checked="1">
            <div dir="ltr" data-orientation="horizontal" bis_skin_checked="1">
                <div class="flex flex-col space-y-1.5 p-6" bis_skin_checked="1">
                    <div role="tablist" aria-orientation="horizontal" class="h-10 items-center justify-center rounded-md bg-gray-100 p-1 text-gray-100-foreground grid w-full grid-cols-4" tabindex="0" data-orientation="horizontal" bis_skin_checked="1" style="outline: none;">
                        <button type="button" role="tab" aria-selected="true" aria-controls="radix-:r1m:-content-active" data-state="active" id="radix-:r1m:-trigger-active" class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:bg-background data-[state=active]:text-foreground data-[state=active]:shadow-sm" tabindex="-1" data-orientation="horizontal" data-radix-collection-item="">✅ النشطة</button>
                        <button type="button" role="tab" aria-selected="false" aria-controls="radix-:r1m:-content-past" data-state="inactive" id="radix-:r1m:-trigger-past" class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:bg-background data-[state=active]:text-foreground data-[state=active]:shadow-sm" tabindex="-1" data-orientation="horizontal" data-radix-collection-item="">🔴 منتهية</button>
                        <button type="button" role="tab" aria-selected="false" aria-controls="radix-:r1m:-content-cancelled" data-state="inactive" id="radix-:r1m:-trigger-cancelled" class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:bg-background data-[state=active]:text-foreground data-[state=active]:shadow-sm" tabindex="-1" data-orientation="horizontal" data-radix-collection-item="">❌ ملغاة</button><button type="button" role="tab" aria-selected="false" aria-controls="radix-:r1m:-content-today" data-state="inactive" id="radix-:r1m:-trigger-today" class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:bg-background data-[state=active]:text-foreground data-[state=active]:shadow-sm" tabindex="-1" data-orientation="horizontal" data-radix-collection-item="">🟡 قيد الاستخدام</button></div>
                </div>
                <div class="p-6 pt-0" bis_skin_checked="1">
                    <div data-state="active" data-orientation="horizontal" role="tabpanel" aria-labelledby="radix-:r1m:-trigger-active" id="radix-:r1m:-content-active" tabindex="0" class="mt-2 ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" bis_skin_checked="1" style="animation-duration: 0s;">
                        <div class="relative w-full overflow-auto" bis_skin_checked="1">
                            <table class="w-full caption-bottom text-sm">
                                <thead class="[&amp;_tr]:border-b">
                                    <tr class="border-b transition-colors hover:bg-gray-100/50 data-[state=selected]:bg-gray-100">
                                        <th class="h-12 px-4 text-right align-middle font-medium text-gray-100-foreground [&amp;:has([role=checkbox])]:pr-0">النوع</th>
                                        <th class="h-12 px-4 text-right align-middle font-medium text-gray-100-foreground [&amp;:has([role=checkbox])]:pr-0">الفعالية/التاجر</th>
                                        <th class="h-12 px-4 text-right align-middle font-medium text-gray-100-foreground [&amp;:has([role=checkbox])]:pr-0">التاريخ</th>
                                        <th class="h-12 px-4 text-right align-middle font-medium text-gray-100-foreground [&amp;:has([role=checkbox])]:pr-0">الحالة</th>
                                        <th class="h-12 px-4 align-middle font-medium text-gray-100-foreground [&amp;:has([role=checkbox])]:pr-0 text-left">إجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($Reservations as $reservation)
                                        <tr class="border-b transition-colors hover:bg-gray-100/50">
                                            <td class="p-4 align-middle font-medium">
                                                {{ $reservation->item_type === 'event' ? 'تذكرة فعالية' : 'حجز طاولة' }}
                                            </td>
                                            <td class="p-4 align-middle">
                                                {{ $reservation->additional_data['merchant_name'] ?? '-' }}
                                            </td>
                                            <td class="p-4 align-middle">
                                                {{ $reservation->additional_data['date'] ?? '-' }}
                                            </td>
                                            <td class="p-4 align-middle">
                                                @php
                                                    $status = $reservation->additional_data['status'] ?? 'غير معروف';
                                                    $statusColor = match($status) {
                                                        'مدفوع' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-800'],
                                                        'مؤكد' => ['bg' => 'bg-sky-100', 'text' => 'text-sky-800'],
                                                        'ملغى' => ['bg' => 'bg-red-100', 'text' => 'text-red-800'],
                                                        default => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800'],
                                                    };
                                                @endphp
                                                <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors {{ $statusColor['bg'] }} {{ $statusColor['text'] }}">
                                                    {{ $status }}
                                                </div>
                                            </td>
                                            <td class="p-4 align-middle text-left flex gap-1 justify-end">
                                                {{-- أي أزرار إجراءات إضافية بتحب تحطها هون --}}
                                                <a href="#" class="text-blue-500 hover:underline text-sm">عرض</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-gray-500">لا يوجد حجوزات حتى الآن.</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                    
                            </table>
                        </div>
                    </div>
                    <div data-state="inactive" data-orientation="horizontal" role="tabpanel" aria-labelledby="radix-:r1m:-trigger-past" hidden="" id="radix-:r1m:-content-past" tabindex="0" class="mt-2 ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" bis_skin_checked="1"></div>
                    <div data-state="inactive" data-orientation="horizontal" role="tabpanel" aria-labelledby="radix-:r1m:-trigger-cancelled" hidden="" id="radix-:r1m:-content-cancelled" tabindex="0" class="mt-2 ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" bis_skin_checked="1"></div>
                    <div data-state="inactive" data-orientation="horizontal" role="tabpanel" aria-labelledby="radix-:r1m:-trigger-today" hidden="" id="radix-:r1m:-content-today" tabindex="0" class="mt-2 ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" bis_skin_checked="1"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
