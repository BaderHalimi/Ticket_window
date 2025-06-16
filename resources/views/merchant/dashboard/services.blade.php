@extends('merchant.layouts.app')
@section('content')

    <div class="flex-1 p-8" bis_skin_checked="1">
        <div bis_skin_checked="1" style="opacity: 1; transform: none;">
            <div class="space-y-8" bis_skin_checked="1">
                <div class="flex justify-between items-center flex-wrap gap-4" bis_skin_checked="1">
                    <h2 class="text-3xl font-bold text-slate-800">إدارة الخدمات</h2><button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-orange-500 hover:bg-orange-500/90 h-10 px-4 py-2 bg-orange-500 text-white"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 ml-2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M8 12h8"></path>
                            <path d="M12 8v8"></path>
                        </svg>إضافة خدمة جديدة</button>
                </div>
                <div dir="rtl" data-orientation="horizontal" class="w-full" bis_skin_checked="1">
                    <div role="tablist" aria-orientation="horizontal" class="items-center justify-center text-muted-foreground grid w-full grid-cols-2 md:grid-cols-4 gap-2 h-auto p-2 bg-orange-500/10 rounded-xl mb-6" tabindex="0" data-orientation="horizontal" bis_skin_checked="1" style="outline: none;"><button type="button" role="tab" aria-selected="true" aria-controls="radix-:rv:-content-events" data-state="active" id="radix-:rv:-trigger-events" class="justify-center whitespace-nowrap rounded-sm px-3 font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 flex items-center gap-2 text-sm md:text-base py-2.5 data-[state=active]:bg-orange-500 data-[state=active]:text-white text-gray-400 data-[state=active]:shadow-lg" tabindex="0" data-orientation="horizontal" data-radix-collection-item=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                                <path d="M5.8 11.3 2 22l10.7-3.79"></path>
                                <path d="M4 3h.01"></path>
                                <path d="M22 8h.01"></path>
                                <path d="M15 2h.01"></path>
                                <path d="M22 20h.01"></path>
                                <path d="m22 2-2.24.75a2.9 2.9 0 0 0-1.96 3.12v0c.1.86-.57 1.63-1.45 1.63h-.38c-.86 0-1.6.6-1.76 1.44L14 10"></path>
                                <path d="m22 13-.82-.33c-.86-.34-1.82.2-1.98 1.11v0c-.11.7-.72 1.22-1.43 1.22H17"></path>
                                <path d="m11 2 .33.82c.34.86-.2 1.82-1.11 1.98v0C9.52 4.9 9 5.52 9 6.23V7"></path>
                                <path d="M11 13c1.93 1.93 2.83 4.17 2 5-.83.83-3.07-.07-5-2-1.93-1.93-2.83-4.17-2-5 .83-.83 3.07.07 5 2Z"></path>
                            </svg>الفعاليات</button><button type="button" role="tab" aria-selected="false" aria-controls="radix-:rv:-content-exhibitions" data-state="inactive" id="radix-:rv:-trigger-exhibitions" class="justify-center whitespace-nowrap rounded-sm px-3 font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 flex items-center gap-2 text-sm md:text-base py-2.5 data-[state=active]:bg-orange-500 data-[state=active]:text-white text-gray-400 data-[state=active]:shadow-lg" tabindex="-1" data-orientation="horizontal" data-radix-collection-item=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                                <path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"></path>
                                <path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"></path>
                                <path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"></path>
                                <path d="M10 6h4"></path>
                                <path d="M10 10h4"></path>
                                <path d="M10 14h4"></path>
                                <path d="M10 18h4"></path>
                            </svg>المعارض والمؤتمرات</button><button type="button" role="tab" aria-selected="false" aria-controls="radix-:rv:-content-restaurants" data-state="inactive" id="radix-:rv:-trigger-restaurants" class="justify-center whitespace-nowrap rounded-sm px-3 font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 flex items-center gap-2 text-sm md:text-base py-2.5 data-[state=active]:bg-orange-500 data-[state=active]:text-white text-gray-400 data-[state=active]:shadow-lg" tabindex="-1" data-orientation="horizontal" data-radix-collection-item=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                                <path d="m16 2-2.3 2.3a3 3 0 0 0 0 4.2l1.8 1.8a3 3 0 0 0 4.2 0L22 8"></path>
                                <path d="M15 15 3.3 3.3a4.2 4.2 0 0 0 0 6l7.3 7.3c.7.7 2 .7 2.8 0L15 15Zm0 0 7 7"></path>
                                <path d="m2.1 21.8 6.4-6.3"></path>
                                <path d="m19 5-7 7"></path>
                            </svg>المطاعم واللاونجات</button><button type="button" role="tab" aria-selected="false" aria-controls="radix-:rv:-content-experiences" data-state="inactive" id="radix-:rv:-trigger-experiences" class="justify-center whitespace-nowrap rounded-sm px-3 font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 flex items-center gap-2 text-sm md:text-base py-2.5 data-[state=active]:bg-orange-500 data-[state=active]:text-white text-gray-400 data-[state=active]:shadow-lg" tabindex="-1" data-orientation="horizontal" data-radix-collection-item=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                                <path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"></path>
                                <path d="M5 3v4"></path>
                                <path d="M19 17v4"></path>
                                <path d="M3 5h4"></path>
                                <path d="M17 19h4"></path>
                            </svg>التجارب (Experiences)</button></div>
                    <div data-state="active" data-orientation="horizontal" role="tabpanel" aria-labelledby="radix-:rv:-trigger-events" id="radix-:rv:-content-events" tabindex="0" class="mt-2 ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" bis_skin_checked="1" style="">
                        <div bis_skin_checked="1" style="opacity: 1; transform: none;">
                            <div class="rounded-2xl border bg-white text-slate-900 overflow-hidden shadow-lg border-t-4 border-orange-500" bis_skin_checked="1">
                                <div class="flex flex-col space-y-1.5 p-6 bg-slate-50" bis_skin_checked="1">
                                    <h3 class="font-semibold tracking-tight text-2xl">تفاصيل مجال الفعاليات</h3>
                                    <p class="text-sm text-slate-500">استعرض الأنواع المدعومة والمميزات الخاصة بهذا المجال.</p>
                                </div>
                                <div class="grid md:grid-cols-2 gap-x-8 gap-y-6 p-6" bis_skin_checked="1">
                                    <div class="space-y-4" bis_skin_checked="1">
                                        <h3 class="font-bold text-lg text-slate-700 mb-4 border-b pb-2">🧩 الأنواع المدعومة</h3>
                                        <ul class="space-y-3">
                                            <li class="flex items-center gap-3 text-slate-600">
                                                <div class="w-5 h-5 bg-orange-500/20 rounded-md flex items-center justify-center shrink-0" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3 h-3 text-orange-500">
                                                        <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path>
                                                        <path d="M13 5v2"></path>
                                                        <path d="M13 17v2"></path>
                                                        <path d="M13 11v2"></path>
                                                    </svg></div><span>فعالية يوم واحد</span>
                                            </li>
                                            <li class="flex items-center gap-3 text-slate-600">
                                                <div class="w-5 h-5 bg-orange-500/20 rounded-md flex items-center justify-center shrink-0" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3 h-3 text-orange-500">
                                                        <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path>
                                                        <path d="M13 5v2"></path>
                                                        <path d="M13 17v2"></path>
                                                        <path d="M13 11v2"></path>
                                                    </svg></div><span>فعالية على عدة أيام</span>
                                            </li>
                                            <li class="flex items-center gap-3 text-slate-600">
                                                <div class="w-5 h-5 bg-orange-500/20 rounded-md flex items-center justify-center shrink-0" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3 h-3 text-orange-500">
                                                        <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path>
                                                        <path d="M13 5v2"></path>
                                                        <path d="M13 17v2"></path>
                                                        <path d="M13 11v2"></path>
                                                    </svg></div><span>فعالية متكررة شهريًا</span>
                                            </li>
                                            <li class="flex items-center gap-3 text-slate-600">
                                                <div class="w-5 h-5 bg-orange-500/20 rounded-md flex items-center justify-center shrink-0" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3 h-3 text-orange-500">
                                                        <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path>
                                                        <path d="M13 5v2"></path>
                                                        <path d="M13 17v2"></path>
                                                        <path d="M13 11v2"></path>
                                                    </svg></div><span>فعالية بمقاعد مرقمة (مسرح/سينما)</span>
                                            </li>
                                            <li class="flex items-center gap-3 text-slate-600">
                                                <div class="w-5 h-5 bg-orange-500/20 rounded-md flex items-center justify-center shrink-0" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3 h-3 text-orange-500">
                                                        <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path>
                                                        <path d="M13 5v2"></path>
                                                        <path d="M13 17v2"></path>
                                                        <path d="M13 11v2"></path>
                                                    </svg></div><span>فعالية مفتوحة بدون مقاعد</span>
                                            </li>
                                            <li class="flex items-center gap-3 text-slate-600">
                                                <div class="w-5 h-5 bg-orange-500/20 rounded-md flex items-center justify-center shrink-0" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3 h-3 text-orange-500">
                                                        <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path>
                                                        <path d="M13 5v2"></path>
                                                        <path d="M13 17v2"></path>
                                                        <path d="M13 11v2"></path>
                                                    </svg></div><span>فعالية VIP / دعوات خاصة</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="space-y-4 md:border-r md:border-slate-200 md:pr-8" bis_skin_checked="1">
                                        <h3 class="font-bold text-lg text-slate-700 mb-4 border-b pb-2">⭐ المميزات الخاصة</h3>
                                        <ul class="space-y-3">
                                            <li class="flex items-start gap-3 text-slate-600"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-amber-400 mt-0.5 shrink-0">
                                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                                </svg><span>مخطط مقاعد تفاعلي (Seat Map)</span></li>
                                            <li class="flex items-start gap-3 text-slate-600"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-amber-400 mt-0.5 shrink-0">
                                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                                </svg><span>تذاكر قابلة للتصميم المخصص</span></li>
                                            <li class="flex items-start gap-3 text-slate-600"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-amber-400 mt-0.5 shrink-0">
                                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                                </svg><span>دعم QR للتحقق من الدخول</span></li>
                                            <li class="flex items-start gap-3 text-slate-600"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-amber-400 mt-0.5 shrink-0">
                                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                                </svg><span>تحديد الفئة (عامة - نسائية - أطفال…)</span></li>
                                            <li class="flex items-start gap-3 text-slate-600"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-amber-400 mt-0.5 shrink-0">
                                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                                </svg><span>إمكانية ربط الفعالية بموقع محدد في الخريطة</span></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="items-center bg-slate-50 p-4 flex justify-start" bis_skin_checked="1"><button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 ml-2">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="M8 12h8"></path>
                                            <path d="M12 8v8"></path>
                                        </svg>إنشاء خدمة جديدة في هذا المجال</button></div>
                            </div>
                        </div>
                    </div>
                    <div data-state="inactive" data-orientation="horizontal" role="tabpanel" aria-labelledby="radix-:rv:-trigger-exhibitions" id="radix-:rv:-content-exhibitions" tabindex="0" class="mt-2 ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" bis_skin_checked="1" hidden=""></div>
                    <div data-state="inactive" data-orientation="horizontal" role="tabpanel" aria-labelledby="radix-:rv:-trigger-restaurants" id="radix-:rv:-content-restaurants" tabindex="0" class="mt-2 ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" bis_skin_checked="1" hidden=""></div>
                    <div data-state="inactive" data-orientation="horizontal" role="tabpanel" aria-labelledby="radix-:rv:-trigger-experiences" id="radix-:rv:-content-experiences" tabindex="0" class="mt-2 ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" bis_skin_checked="1" hidden=""></div>
                </div>
            </div>
        </div>
    </div>
@endsection
