@extends('merchant.layouts.app')
@section('content')
<div class="flex-1 p-8" bis_skin_checked="1">
    <div bis_skin_checked="1" style="opacity: 1; transform: none;">
        <div class="space-y-6" bis_skin_checked="1">
            <h2 class="text-3xl font-bold text-slate-800">إدارة الحجوزات</h2>
            <div dir="rtl" data-orientation="horizontal" class="w-full" bis_skin_checked="1">
                <div role="tablist" aria-orientation="horizontal" class="items-center justify-center text-muted-foreground grid w-full grid-cols-2 md:grid-cols-4 gap-2 h-auto p-2 bg-orange-500/10 rounded-xl mb-6" tabindex="0" data-orientation="horizontal" bis_skin_checked="1" style="outline: none;"><button type="button" role="tab" aria-selected="true" aria-controls="radix-:r18:-content-all" data-state="active" id="radix-:r18:-trigger-all" class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 text-sm md:text-base py-2.5 data-[state=active]:bg-orange-500 data-[state=active]:text-white text-gray-400 data-[state=active]:shadow-lg" tabindex="0" data-orientation="horizontal" data-radix-collection-item="">كل الحجوزات <span class="mr-2 bg-white/20 text-xs font-bold px-2 py-0.5 rounded-full">12</span></button><button type="button" role="tab" aria-selected="false" aria-controls="radix-:r18:-content-active" data-state="inactive" id="radix-:r18:-trigger-active" class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 text-sm md:text-base py-2.5 data-[state=active]:bg-orange-500 data-[state=active]:text-white text-gray-400 data-[state=active]:shadow-lg" tabindex="-1" data-orientation="horizontal" data-radix-collection-item="">النشطة <span class="mr-2 bg-white/20 text-xs font-bold px-2 py-0.5 rounded-full">6</span></button><button type="button" role="tab" aria-selected="false" aria-controls="radix-:r18:-content-cancelled" data-state="inactive" id="radix-:r18:-trigger-cancelled" class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 text-sm md:text-base py-2.5 data-[state=active]:bg-orange-500 data-[state=active]:text-white text-gray-400 data-[state=active]:shadow-lg" tabindex="-1" data-orientation="horizontal" data-radix-collection-item="">الملغاة <span class="mr-2 bg-white/20 text-xs font-bold px-2 py-0.5 rounded-full">3</span></button><button type="button" role="tab" aria-selected="false" aria-controls="radix-:r18:-content-finished" data-state="inactive" id="radix-:r18:-trigger-finished" class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 text-sm md:text-base py-2.5 data-[state=active]:bg-orange-500 data-[state=active]:text-white text-gray-400 data-[state=active]:shadow-lg" tabindex="-1" data-orientation="horizontal" data-radix-collection-item="">المنتهية <span class="mr-2 bg-white/20 text-xs font-bold px-2 py-0.5 rounded-full">3</span></button></div>
                <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg" bis_skin_checked="1">
                    <div class="flex flex-col space-y-1.5 border-b border-slate-200 p-4" bis_skin_checked="1">
                        <div class="flex justify-between items-center flex-wrap gap-4" bis_skin_checked="1">
                            <div class="flex items-center gap-2 flex-wrap" bis_skin_checked="1">
                                <div class="relative flex-1 min-w-[200px]" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-500">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <path d="m21 21-4.3-4.3"></path>
                                    </svg><input class="flex h-10 w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all pl-10" placeholder="ابحث..." value=""></div><button class="inline-flex items-center rounded-md text-sm ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 w-[250px] justify-start text-left font-normal text-muted-foreground" id="date" type="button" aria-haspopup="dialog" aria-expanded="false" aria-controls="radix-:r1d:" data-state="closed"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-2 h-4 w-4">
                                        <rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect>
                                        <line x1="16" x2="16" y1="2" y2="6"></line>
                                        <line x1="8" x2="8" y1="2" y2="6"></line>
                                        <line x1="3" x2="21" y1="10" y2="10"></line>
                                    </svg><span>اختر نطاق زمني</span></button><button class="items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 flex gap-2" type="button" id="radix-:r1e:" aria-haspopup="menu" aria-expanded="false" data-state="closed"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                        <line x1="21" x2="14" y1="4" y2="4"></line>
                                        <line x1="10" x2="3" y1="4" y2="4"></line>
                                        <line x1="21" x2="12" y1="12" y2="12"></line>
                                        <line x1="8" x2="3" y1="12" y2="12"></line>
                                        <line x1="21" x2="16" y1="20" y2="20"></line>
                                        <line x1="12" x2="3" y1="20" y2="20"></line>
                                        <line x1="14" x2="14" y1="2" y2="6"></line>
                                        <line x1="8" x2="8" y1="10" y2="14"></line>
                                        <line x1="16" x2="16" y1="18" y2="22"></line>
                                    </svg><span>نوع الخدمة</span></button>
                            </div>
                            <div class="flex items-center gap-2" bis_skin_checked="1"><button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 ml-2">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="7 10 12 15 17 10"></polyline>
                                        <line x1="12" x2="12" y1="15" y2="3"></line>
                                    </svg>تصدير</button></div>
                        </div>
                    </div>
                    <div class="px-8 py-0" bis_skin_checked="1">
                        <div class="overflow-x-auto" bis_skin_checked="1">
                            <div class="relative w-full overflow-auto" bis_skin_checked="1">
                                <table class="w-full caption-bottom text-sm px-20">
                                    <thead class="[&amp;_tr]:border-b">
                                        <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                            <th class="h-12 text-right align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0 w-[50px] px-4"><button type="button" role="checkbox" aria-checked="false" data-state="unchecked" value="on" class="peer h-4 w-4 shrink-0 rounded-sm border border-orange-500 ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-orange-500 data-[state=checked]:text-orange-500-foreground"></button></th>
                                            <th class="h-12 px-4 text-right align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0"><button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-10 py-2 px-0">العميل<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 ml-2 opacity-30">
                                                        <path d="m21 16-4 4-4-4"></path>
                                                        <path d="M17 20V4"></path>
                                                        <path d="m3 8 4-4 4 4"></path>
                                                        <path d="M7 4v16"></path>
                                                    </svg></button></th>
                                            <th class="h-12 px-4 text-right align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0">الخدمة</th>
                                            <th class="h-12 px-4 text-right align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0">الحالة</th>
                                            <th class="h-12 px-4 text-right align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0"><button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-10 py-2 px-0">المبلغ<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 ml-2 opacity-30">
                                                        <path d="m21 16-4 4-4-4"></path>
                                                        <path d="M17 20V4"></path>
                                                        <path d="m3 8 4-4 4 4"></path>
                                                        <path d="M7 4v16"></path>
                                                    </svg></button></th>
                                            <th class="h-12 px-4 text-right align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0"><button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-10 py-2 px-0">التاريخ<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 ml-2 text-orange-500">
                                                        <path d="m21 16-4 4-4-4"></path>
                                                        <path d="M17 20V4"></path>
                                                        <path d="m3 8 4-4 4 4"></path>
                                                        <path d="M7 4v16"></path>
                                                    </svg></button></th>
                                            <th class="h-12 px-4 align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0 text-center">إجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody class="[&amp;_tr:last-child]:border-0">
                                        <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted" data-state="false">
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 px-4"><button type="button" role="checkbox" aria-checked="false" data-state="unchecked" value="on" class="peer h-4 w-4 shrink-0 rounded-sm border border-orange-500 ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-orange-500 data-[state=checked]:text-orange-500-foreground"></button></td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 font-medium text-slate-900">
                                                <div class="flex items-center gap-3" bis_skin_checked="1"><span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full"><span class="flex h-full w-full items-center justify-center rounded-full bg-muted">س</span></span>
                                                    <div bis_skin_checked="1">
                                                        <div class="font-semibold" bis_skin_checked="1">سارة عبدالله</div>
                                                        <div class="text-xs text-slate-500 font-mono" bis_skin_checked="1">BK-5987</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">
                                                <div bis_skin_checked="1">ورشة عمل فنية</div>
                                                <div class="text-xs text-muted-foreground" bis_skin_checked="1">فعالية</div>
                                            </td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0"><span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">ملغي من العميل</span></td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 font-mono">200.00 ريال</td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">2025-06-15</td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 text-center"><button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-10 w-10" type="button" aria-haspopup="dialog" aria-expanded="false" aria-controls="radix-:r15:" data-state="closed"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 text-slate-500">
                                                        <circle cx="12" cy="12" r="1"></circle>
                                                        <circle cx="19" cy="12" r="1"></circle>
                                                        <circle cx="5" cy="12" r="1"></circle>
                                                    </svg></button></td>
                                        </tr>
                                        <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted" data-state="false">
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 px-4"><button type="button" role="checkbox" aria-checked="false" data-state="unchecked" value="on" class="peer h-4 w-4 shrink-0 rounded-sm border border-orange-500 ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-orange-500 data-[state=checked]:text-orange-500-foreground"></button></td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 font-medium text-slate-900">
                                                <div class="flex items-center gap-3" bis_skin_checked="1"><span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full"><span class="flex h-full w-full items-center justify-center rounded-full bg-muted">ه</span></span>
                                                    <div bis_skin_checked="1">
                                                        <div class="font-semibold" bis_skin_checked="1">هند المطيري</div>
                                                        <div class="text-xs text-slate-500 font-mono" bis_skin_checked="1">BK-1125</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">
                                                <div bis_skin_checked="1">ورشة عمل فنية</div>
                                                <div class="text-xs text-muted-foreground" bis_skin_checked="1">فعالية</div>
                                            </td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0"><span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">مدفوع</span></td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 font-mono">200.00 ريال</td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">2025-06-15</td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 text-center"><button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-10 w-10" type="button" aria-haspopup="dialog" aria-expanded="false" aria-controls="radix-:r15:" data-state="closed"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 text-slate-500">
                                                        <circle cx="12" cy="12" r="1"></circle>
                                                        <circle cx="19" cy="12" r="1"></circle>
                                                        <circle cx="5" cy="12" r="1"></circle>
                                                    </svg></button></td>
                                        </tr>
                                        <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted" data-state="false">
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 px-4"><button type="button" role="checkbox" aria-checked="false" data-state="unchecked" value="on" class="peer h-4 w-4 shrink-0 rounded-sm border border-orange-500 ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-orange-500 data-[state=checked]:text-orange-500-foreground"></button></td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 font-medium text-slate-900">
                                                <div class="flex items-center gap-3" bis_skin_checked="1"><span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full"><span class="flex h-full w-full items-center justify-center rounded-full bg-muted">ع</span></span>
                                                    <div bis_skin_checked="1">
                                                        <div class="font-semibold" bis_skin_checked="1">عبدالرحمن الشهري</div>
                                                        <div class="text-xs text-slate-500 font-mono" bis_skin_checked="1">BK-2789</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">
                                                <div bis_skin_checked="1">حجز طاولة VIP</div>
                                                <div class="text-xs text-muted-foreground" bis_skin_checked="1">مطعم</div>
                                            </td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0"><span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-sky-100 text-sky-800">مقبول يدويًا</span></td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 font-mono">800.00 ريال</td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">2025-06-14</td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 text-center"><button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-10 w-10" type="button" aria-haspopup="dialog" aria-expanded="false" aria-controls="radix-:r15:" data-state="closed"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 text-slate-500">
                                                        <circle cx="12" cy="12" r="1"></circle>
                                                        <circle cx="19" cy="12" r="1"></circle>
                                                        <circle cx="5" cy="12" r="1"></circle>
                                                    </svg></button></td>
                                        </tr>
                                        <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted" data-state="false">
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 px-4"><button type="button" role="checkbox" aria-checked="false" data-state="unchecked" value="on" class="peer h-4 w-4 shrink-0 rounded-sm border border-orange-500 ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-orange-500 data-[state=checked]:text-orange-500-foreground"></button></td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 font-medium text-slate-900">
                                                <div class="flex items-center gap-3" bis_skin_checked="1"><span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full"><span class="flex h-full w-full items-center justify-center rounded-full bg-muted">ف</span></span>
                                                    <div bis_skin_checked="1">
                                                        <div class="font-semibold" bis_skin_checked="1">فاطمة الزهراني</div>
                                                        <div class="text-xs text-slate-500 font-mono" bis_skin_checked="1">BK-7654</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">
                                                <div bis_skin_checked="1">حجز طاولة عشاء</div>
                                                <div class="text-xs text-muted-foreground" bis_skin_checked="1">مطعم</div>
                                            </td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0"><span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-cyan-100 text-cyan-800">بانتظار الموافقة</span></td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 font-mono">300.00 ريال</td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">2025-06-13</td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 text-center"><button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-10 w-10" type="button" aria-haspopup="dialog" aria-expanded="false" aria-controls="radix-:r15:" data-state="closed"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 text-slate-500">
                                                        <circle cx="12" cy="12" r="1"></circle>
                                                        <circle cx="19" cy="12" r="1"></circle>
                                                        <circle cx="5" cy="12" r="1"></circle>
                                                    </svg></button></td>
                                        </tr>
                                        <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted" data-state="false">
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 px-4"><button type="button" role="checkbox" aria-checked="false" data-state="unchecked" value="on" class="peer h-4 w-4 shrink-0 rounded-sm border border-orange-500 ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-orange-500 data-[state=checked]:text-orange-500-foreground"></button></td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 font-medium text-slate-900">
                                                <div class="flex items-center gap-3" bis_skin_checked="1"><span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full"><span class="flex h-full w-full items-center justify-center rounded-full bg-muted">ل</span></span>
                                                    <div bis_skin_checked="1">
                                                        <div class="font-semibold" bis_skin_checked="1">لمى خالد</div>
                                                        <div class="text-xs text-slate-500 font-mono" bis_skin_checked="1">BK-1123</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">
                                                <div bis_skin_checked="1">حجز طاولة عشاء</div>
                                                <div class="text-xs text-muted-foreground" bis_skin_checked="1">مطعم</div>
                                            </td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0"><span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">مدفوع</span></td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 font-mono">250.00 ريال</td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">2025-06-13</td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 text-center"><button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-10 w-10" type="button" aria-haspopup="dialog" aria-expanded="false" aria-controls="radix-:r15:" data-state="closed"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 text-slate-500">
                                                        <circle cx="12" cy="12" r="1"></circle>
                                                        <circle cx="19" cy="12" r="1"></circle>
                                                        <circle cx="5" cy="12" r="1"></circle>
                                                    </svg></button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-4 border-t" bis_skin_checked="1">
                        <div class="text-sm text-slate-500" bis_skin_checked="1">صفحة 1 من 3</div>
                        <div class="flex items-center gap-1" bis_skin_checked="1"><button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-8 w-8" disabled=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                    <path d="m6 17 5-5-5-5"></path>
                                    <path d="m13 17 5-5-5-5"></path>
                                </svg></button><button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-8 w-8" disabled=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                    <path d="m9 18 6-6-6-6"></path>
                                </svg></button><button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-8 w-8"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                    <path d="m15 18-6-6 6-6"></path>
                                </svg></button><button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-8 w-8"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                    <path d="m11 17-5-5 5-5"></path>
                                    <path d="m18 17-5-5 5-5"></path>
                                </svg></button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
