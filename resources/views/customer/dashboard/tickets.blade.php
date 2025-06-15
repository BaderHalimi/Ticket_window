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
                                <tbody class="[&amp;_tr:last-child]:border-0">
                                    <tr class="border-b transition-colors hover:bg-gray-100/50 data-[state=selected]:bg-gray-100">
                                        <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 font-medium">تذكرة فعالية</td>
                                        <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">فعالية الشتاء</td>
                                        <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">2025-12-16</td>
                                        <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">
                                            <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent hover:bg-primary/80 bg-emerald-100 text-emerald-800" bis_skin_checked="1">مدفوع</div>
                                        </td>
                                        <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 text-left flex gap-1 justify-end"><button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-gray-200 hover:text-gray-200-foreground h-10 w-10"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                </svg></button><button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-gray-200 hover:text-gray-200-foreground h-10 w-10"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                    <path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4Z"></path>
                                                </svg></button><button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-gray-200 hover:text-gray-200-foreground h-10 w-10 text-red-500"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="m15 9-6 6"></path>
                                                    <path d="m9 9 6 6"></path>
                                                </svg></button></td>
                                    </tr>
                                    <tr class="border-b transition-colors hover:bg-gray-100/50 data-[state=selected]:bg-gray-100">
                                        <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 font-medium">حجز طاولة</td>
                                        <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">مطعم الذواقة</td>
                                        <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">2025-12-20</td>
                                        <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">
                                            <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent hover:bg-primary/80 bg-sky-100 text-sky-800" bis_skin_checked="1">مؤكد</div>
                                        </td>
                                        <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 text-left flex gap-1 justify-end"><button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-gray-200 hover:text-gray-200-foreground h-10 w-10"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                </svg></button><button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-gray-200 hover:text-gray-200-foreground h-10 w-10"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                    <path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4Z"></path>
                                                </svg></button><button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-gray-200 hover:text-gray-200-foreground h-10 w-10 text-red-500"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="m15 9-6 6"></path>
                                                    <path d="m9 9 6 6"></path>
                                                </svg></button></td>
                                    </tr>
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
