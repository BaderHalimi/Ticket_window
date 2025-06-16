@extends('merchant.layouts.app')
@section('content')
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

@endsection
