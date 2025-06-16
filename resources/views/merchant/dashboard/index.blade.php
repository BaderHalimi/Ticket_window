@extends('merchant.layouts.app')
@section('content')
<main class="flex-1 overflow-y-auto flex flex-col">
    <header class="bg-white shadow-sm p-4 flex justify-between items-center sticky top-0 z-30">
        <div class="flex-1 min-w-0" bis_skin_checked="1">
            <div class="w-64" bis_skin_checked="1"><button type="button" role="combobox" aria-controls="radix-:r8:" aria-expanded="false" aria-autocomplete="none" dir="rtl" data-state="closed" class="flex h-10 items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 w-full"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 ml-2">
                        <line x1="6" x2="6" y1="3" y2="15"></line>
                        <circle cx="18" cy="6" r="3"></circle>
                        <circle cx="6" cy="18" r="3"></circle>
                        <path d="M18 9a9 9 0 0 1-9 9"></path>
                    </svg><span style="pointer-events: none;">كل الفروع</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 opacity-50" aria-hidden="true">
                        <path d="m6 9 6 6 6-6"></path>
                    </svg></button></div>
        </div>
        <div class="flex items-center gap-4" bis_skin_checked="1"><button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-10 w-10 relative text-slate-600"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                    <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
                    <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>
                </svg><span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span></button><span class="relative flex shrink-0 overflow-hidden rounded-full cursor-pointer h-9 w-9" type="button" id="radix-:r9:" aria-haspopup="menu" aria-expanded="false" data-state="closed"><img class="aspect-square h-full w-full" alt="Merchant" src="https://images.unsplash.com/photo-1600486913747-55e5470d6f40?q=80&amp;w=200"></span></div>
    </header>
    <div class="flex-1 p-8" bis_skin_checked="1">
        <div bis_skin_checked="1" style="opacity: 1; transform: none;">
            <div class="space-y-8" bis_skin_checked="1">
                <h2 class="text-3xl font-bold text-slate-800">نظرة عامة</h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6" bis_skin_checked="1">
                    <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg card-hover" bis_skin_checked="1">
                        <div class="space-y-1.5 p-6 flex flex-row items-center justify-between pb-2" bis_skin_checked="1">
                            <h3 class="tracking-tight text-sm font-medium text-slate-500">إجمالي المبيعات (اليوم)</h3>
                            <div class="w-8 h-8 flex items-center justify-center rounded-lg text-white from-green-400 to-emerald-500" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                                    <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
                                    <polyline points="16 7 22 7 22 13"></polyline>
                                </svg></div>
                        </div>
                        <div class="p-6 pt-0" bis_skin_checked="1">
                            <p class="text-3xl font-bold text-slate-900">2,560 ريال</p>
                        </div>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg card-hover" bis_skin_checked="1">
                        <div class="space-y-1.5 p-6 flex flex-row items-center justify-between pb-2" bis_skin_checked="1">
                            <h3 class="tracking-tight text-sm font-medium text-slate-500">الحجوزات النشطة</h3>
                            <div class="w-8 h-8 flex items-center justify-center rounded-lg text-white from-blue-400 to-sky-500" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                                    <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path>
                                    <path d="M13 5v2"></path>
                                    <path d="M13 17v2"></path>
                                    <path d="M13 11v2"></path>
                                </svg></div>
                        </div>
                        <div class="p-6 pt-0" bis_skin_checked="1">
                            <p class="text-3xl font-bold text-slate-900">78</p>
                        </div>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg card-hover" bis_skin_checked="1">
                        <div class="space-y-1.5 p-6 flex flex-row items-center justify-between pb-2" bis_skin_checked="1">
                            <h3 class="tracking-tight text-sm font-medium text-slate-500">الرصيد المتاح</h3>
                            <div class="w-8 h-8 flex items-center justify-center rounded-lg text-white bg-orange-500" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                                    <path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"></path>
                                    <path d="M3 5v14a2 2 0 0 0 2 2h16v-5"></path>
                                    <path d="M18 12a2 2 0 0 0 0 4h4v-4Z"></path>
                                </svg></div>
                        </div>
                        <div class="p-6 pt-0" bis_skin_checked="1">
                            <p class="text-3xl font-bold text-slate-900">15,300 ريال</p>
                        </div>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg card-hover" bis_skin_checked="1">
                        <div class="space-y-1.5 p-6 flex flex-row items-center justify-between pb-2" bis_skin_checked="1">
                            <h3 class="tracking-tight text-sm font-medium text-slate-500">أكثر الفعاليات حجزاً</h3>
                            <div class="w-8 h-8 flex items-center justify-center rounded-lg text-white from-amber-400 to-orange-500" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                                    <path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"></path>
                                    <path d="M5 3v4"></path>
                                    <path d="M19 17v4"></path>
                                    <path d="M3 5h4"></path>
                                    <path d="M17 19h4"></path>
                                </svg></div>
                        </div>
                        <div class="p-6 pt-0" bis_skin_checked="1">
                            <p class="text-3xl font-bold text-slate-900">معرض التقنية</p>
                        </div>
                    </div>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg" bis_skin_checked="1">
                    <div class="flex flex-col space-y-1.5 p-6" bis_skin_checked="1">
                        <h3 class="text-xl font-semibold leading-none tracking-tight">الإشعارات الجديدة</h3>
                    </div>
                    <div class="p-6 pt-0" bis_skin_checked="1">
                        <p class="text-slate-500">لا توجد إشعارات جديدة حالياً.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
