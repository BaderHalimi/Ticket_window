@extends('merchant.layouts.app')
@section('content')

<div class="flex-1 p-8 space-y-12">

    {{-- العنوان وزر الإضافة --}}
    <div class="flex justify-between items-center flex-wrap gap-4">
        <h2 class="text-3xl font-bold text-slate-800">إدارة الخدمات</h2>
        <a href="{{ route('merchant.dashboard.offer.create') }}">
            <button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-orange-500 hover:bg-orange-500/90 h-10 px-4 py-2 text-white">
                <svg class="w-5 h-5 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M8 12h8M12 8v8"></path>
                </svg>
                إضافة خدمة جديدة
            </button>
        </a>
    </div>

    {{-- التبويبات --}}
    <!-- <div class="w-full">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-2 p-2 bg-orange-500/10 rounded-xl mb-6">
            <button class="flex items-center justify-center gap-2 py-2.5 px-3 text-sm md:text-base font-medium rounded-sm text-white bg-orange-500 shadow-lg">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M5.8 11.3L2 22l10.7-3.79" />
                    <path d="M4 3h.01M22 8h.01M15 2h.01M22 20h.01" />
                    <path d="m22 2-2.24.75a2.9 2.9 0 0 0-1.96 3.12c.1.86-.57 1.63-1.45 1.63h-.38c-.86 0-1.6.6-1.76 1.44L14 10" />
                    <path d="m22 13-.82-.33c-.86-.34-1.82.2-1.98 1.11-.11.7-.72 1.22-1.43 1.22H17" />
                    <path d="m11 2 .33.82c.34.86-.2 1.82-1.11 1.98-.7.11-1.22.72-1.22 1.43V7" />
                    <path d="M11 13c1.93 1.93 2.83 4.17 2 5-.83.83-3.07-.07-5-2-1.93-1.93-2.83-4.17-2-5 .83-.83 3.07.07 5 2Z" />
                </svg>
                الفعاليات
            </button>
            <button type="button" role="tab" aria-selected="false" aria-controls="radix-:rv:-content-exhibitions" data-state="inactive" id="radix-:rv:-trigger-exhibitions" class="justify-center whitespace-nowrap rounded-sm px-3 font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 flex items-center gap-2 text-sm md:text-base py-2.5 data-[state=active]:bg-orange-500 data-[state=active]:text-white text-gray-400 data-[state=active]:shadow-lg" tabindex="-1" data-orientation="horizontal" data-radix-collection-item=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                    <path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"></path>
                    <path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"></path>
                    <path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"></path>
                    <path d="M10 6h4"></path>
                    <path d="M10 10h4"></path>
                    <path d="M10 14h4"></path>
                    <path d="M10 18h4"></path>
                </svg>المعارض والمؤتمرات
            </button>
            <button type="button" role="tab" aria-selected="false" aria-controls="radix-:rv:-content-restaurants" data-state="inactive" id="radix-:rv:-trigger-restaurants" class="justify-center whitespace-nowrap rounded-sm px-3 font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 flex items-center gap-2 text-sm md:text-base py-2.5 data-[state=active]:bg-orange-500 data-[state=active]:text-white text-gray-400 data-[state=active]:shadow-lg" tabindex="-1" data-orientation="horizontal" data-radix-collection-item=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                    <path d="m16 2-2.3 2.3a3 3 0 0 0 0 4.2l1.8 1.8a3 3 0 0 0 4.2 0L22 8"></path>
                    <path d="M15 15 3.3 3.3a4.2 4.2 0 0 0 0 6l7.3 7.3c.7.7 2 .7 2.8 0L15 15Zm0 0 7 7"></path>
                    <path d="m2.1 21.8 6.4-6.3"></path>
                    <path d="m19 5-7 7"></path>
                </svg>المطاعم واللاونجات
            </button>
            <button type="button" role="tab" aria-selected="false" aria-controls="radix-:rv:-content-experiences" data-state="inactive" id="radix-:rv:-trigger-experiences" class="justify-center whitespace-nowrap rounded-sm px-3 font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 flex items-center gap-2 text-sm md:text-base py-2.5 data-[state=active]:bg-orange-500 data-[state=active]:text-white text-gray-400 data-[state=active]:shadow-lg" tabindex="-1" data-orientation="horizontal" data-radix-collection-item=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                    <path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"></path>
                    <path d="M5 3v4"></path>
                    <path d="M19 17v4"></path>
                    <path d="M3 5h4"></path>
                    <path d="M17 19h4"></path>
                </svg>التجارب (Experiences)
            </button>
        </div>

        {{-- تفاصيل الفعاليات --}}
        <div class="bg-white rounded-2xl shadow-lg border-t-4 border-orange-500">
            <div class="p-6 bg-slate-50 space-y-2">
                <h3 class="text-2xl font-semibold">تفاصيل مجال الفعاليات</h3>
                <p class="text-sm text-slate-500">استعرض الأنواع المدعومة والمميزات الخاصة بهذا المجال.</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 p-6">
                {{-- أنواع الفعاليات --}}
                <div>
                    <h4 class="text-lg font-bold text-slate-700 mb-3 border-b pb-2">🧩 الأنواع المدعومة</h4>
                    <ul class="space-y-3 text-slate-600">
                        @foreach ([
                        'فعالية يوم واحد',
                        'فعالية على عدة أيام',
                        'فعالية متكررة شهريًا',
                        'فعالية بمقاعد مرقمة (مسرح/سينما)',
                        'فعالية مفتوحة بدون مقاعد',
                        'فعالية VIP / دعوات خاصة',
                        ] as $type)
                        <li class="flex items-center gap-3">
                            <div class="w-5 h-5 bg-orange-500/20 rounded-md flex items-center justify-center">
                                <svg class="w-3 h-3 text-orange-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z" />
                                    <path d="M13 5v2M13 11v2M13 17v2" />
                                </svg>
                            </div>
                            <span>{{ $type }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- المميزات --}}
                <div>
                    <h4 class="text-lg font-bold text-slate-700 mb-3 border-b pb-2">⭐ المميزات الخاصة</h4>
                    <ul class="space-y-3 text-slate-600">
                        @foreach ([
                        'مخطط مقاعد تفاعلي (Seat Map)',
                        'تذاكر قابلة للتصميم المخصص',
                        'دعم QR للتحقق من الدخول',
                        'تحديد الفئة (عامة - نسائية - أطفال…)',
                        'إمكانية ربط الفعالية بموقع محدد في الخريطة',
                        ] as $feature)
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-amber-400 mt-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                            </svg>
                            <span>{{ $feature }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- زر أسفل البانر --}}
            <div class="p-4 bg-slate-50 flex justify-start">
                <a href="{{ route('merchant.dashboard.offer.create') }}">
                    <button class="inline-flex items-center gap-2 rounded-md text-sm font-medium border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M8 12h8M12 8v8" />
                        </svg>
                        إنشاء خدمة جديدة في هذا المجال
                    </button>
                </a>
            </div>
        </div>
    </div> -->

    {{-- جدول الخدمات --}}
    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
            <h2 class="text-xl font-bold text-slate-800">قائمة الخدمات</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm text-slate-700 rtl:text-right">
                <thead class="bg-orange-500/10 text-orange-800 font-semibold">
                    <tr>
                        <th class="px-4 py-3 text-start">#</th>
                        <th class="px-4 py-3 text-start">الاسم</th>
                        <th class="px-4 py-3 text-start">النوع</th>
                        <th class="px-4 py-3 text-start">السعر</th>
                        <th class="px-4 py-3 text-start">الحالة</th>
                        <th class="px-4 py-3 text-start">البداية</th>
                        <th class="px-4 py-3 text-start">النهاية</th>
                        <th class="px-4 py-3 text-start">التحكم</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($offers as $service)
                        @if ($service->type === 'events')
                        @php
                        $times = fetch_time($service->id);
                        //dd($times);
                        @endphp
                            <tr>
                                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 font-medium">{{ $service->name }}</td>
                                <td class="px-4 py-2">{{ ucfirst($service->type) }}</td>
                                <td class="px-4 py-2">{{ $service->price ?? '—' }}</td>
                                <td class="px-4 py-2">
                                    <span class="inline-block px-2 py-1 text-xs rounded
                                            {{ $service->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $service->status === 'active' ? 'فعال' : 'غير فعال' }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">{{ $times['data'][0]['start_date'] ?? NULL}}</td>
                                <td class="px-4 py-2">{{ $times['data'][0]['end_date'] ?? NULL}}</td>
                                <td class="px-4 py-2 space-x-1 rtl:space-x-reverse">
                                    <a href="{{ route('merchant.dashboard.offer.edit', $service->id) }}" class="text-blue-600 hover:underline text-xs">تعديل</a>
                                    <form method="POST" action="{{ route('merchant.dashboard.offer.destroy', $service->id) }}" class="inline-block" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline text-xs">حذف</button>
                                    </form>
                                </td>
                            </tr>
                        @endif

                    @empty
                    <tr>
                        <td colspan="8" class="text-center px-4 py-6 text-slate-500">لا توجد خدمات حالياً.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection


