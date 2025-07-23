<div class="w-full max-w-6xl mx-auto" x-data="{ showForm: false }">

    {{-- البانر --}}
    <div class="relative w-full h-52 md:h-64 bg-cover bg-center rounded-b-3xl shadow-2xl ring-1 ring-orange-200"
         style="background-image: url('{{ asset('storage/' . $merchant['additional_data']['banner']) }}')">
    </div>

    {{-- الصورة الشخصية --}}
    <div class="relative w-full flex justify-center -mt-16 md:-mt-20 z-10">
        <img src="{{ asset('storage/' . $merchant['additional_data']['profile_picture']) }}"
             class="w-32 h-32 md:w-40 md:h-40 rounded-full border-4 border-white shadow-2xl object-cover ring-2 ring-orange-400" />
    </div>

    {{-- معلومات التاجر --}}
    <div class="text-center mt-4 px-4">
        <h1 class="text-2xl md:text-3xl font-bold text-slate-800">{{ $merchant['f_name'] }} {{ $merchant['l_name'] }}</h1>
        <p class="text-slate-600 mt-1 text-lg font-medium">{{ $merchant['business_name'] }}</p>
        <p class="text-slate-500 text-sm">{{ $merchant['phone'] }}</p>

        {{-- روابط تواصل اجتماعي --}}
        @if(isset($merchant['additional_data']['social_links']))
            <div class="flex justify-center gap-4 mt-4 text-2xl text-slate-700">
                @foreach($merchant['additional_data']['social_links'] as $link)
                    @php
                        $platform = '';
                        if (str_contains($link, 'instagram')) $platform = 'instagram';
                        elseif (str_contains($link, 'facebook')) $platform = 'facebook';
                        elseif (str_contains($link, 'tiktok')) $platform = 'tiktok';
                        else $platform = 'global';
                    @endphp

                    <a href="{{ $link }}" target="_blank" class="hover:text-orange-500 transition duration-300">
                        <i class="ri-{{ $platform }}-fill"></i>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    {{-- تبويبات العروض --}}
    <div x-data="{ tab: 'services' }" class="mt-10 px-4">
        <div class="flex justify-center gap-6 mb-6">
            <button @click="tab = 'services'"
                    :class="tab === 'services' ? 'text-orange-600 border-b-2 border-orange-600' : 'text-slate-600'"
                    class="pb-1 text-lg font-semibold transition">
                الخدمات
            </button>
            <button @click="tab = 'events'"
                    :class="tab === 'events' ? 'text-orange-600 border-b-2 border-orange-600' : 'text-slate-600'"
                    class="pb-1 text-lg font-semibold transition">
                الفعاليات
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($offers_collection as $offer)
                @php
                    $type = $offer['type'] ?? 'services';
                    $features = $offer['features'];
                    if (is_string($features)) $features = json_decode($features, true);
                    $calendar = $features['calendar'][0] ?? null;
                @endphp

                <div x-show="tab === '{{ $type }}'"
                     x-transition
                     class="bg-white shadow-lg hover:shadow-xl ring-1 ring-orange-100 rounded-2xl overflow-hidden transition duration-300">
                    <img src="{{ asset('storage/' . $offer['image']) }}" class="w-full h-40 object-cover" />

                    <div class="p-4 space-y-2">
                        <h3 class="text-lg font-bold text-slate-800">{{ $offer['name'] }}</h3>
                        <p class="text-sm text-slate-600">{{ Str::limit($offer['description'], 100) }}</p>

                        <div class="text-sm text-slate-700 mt-2 space-y-1">
                            <p class="flex items-center gap-1">
                                <i class="ri-map-pin-line text-orange-500"></i> {{ $offer['location'] }}
                            </p>
                            <p class="flex items-center gap-1">
                                <i class="ri-cash-line text-orange-500"></i> {{ $offer['price'] }} د.ج
                            </p>
                        </div>

                        @if($calendar)
                            <div class="text-sm text-slate-600 mt-2 space-y-1">
                                <p class="flex items-center gap-1">
                                    <i class="ri-time-line text-orange-500"></i> {{ $calendar['start_time'] }} - {{ $calendar['end_time'] }}
                                </p>
                                <p class="flex items-center gap-1">
                                    <i class="ri-calendar-line text-orange-500"></i> {{ $calendar['start_date'] }} إلى {{ $calendar['end_date'] }}
                                </p>
                            </div>
                        @endif

                        <div class="pt-4">
<!-- الزر داخل البطاقة -->
<button @click="showForm = true" wire:click="selectOffer('{{ $offer['id'] }}')"
    class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold px-4 py-2 rounded-xl shadow transition-all duration-300">
    <i class="ri-calendar-check-line text-lg"></i>
    حجز الآن
</button>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


    
@if ($selectedOffer)
<div x-show="showForm" x-transition
    class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50"
    @click.self="showForm = false">
   <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-lg relative">
       <button wire:click="resetForm" @click="showForm = false" 
               class="absolute top-3 right-3 text-slate-400 hover:text-orange-500 text-xl">
           <i class="ri-close-line"></i>
       </button>

       <h2 class="text-xl font-bold mb-4 text-slate-800">حجز الموعد</h2>

    @if ($step == 0)
        <div class="space-y-4 text-slate-700">
            {{-- صورة العرض --}}
            <div class="w-full h-40 rounded-xl overflow-hidden shadow">
                <img src="{{ asset('storage/' . $selectedOffer->image) }}"
                    alt="{{ $selectedOffer->title }}"
                    class="w-full h-full object-cover" />
            </div>
        
            {{-- العنوان والسعر --}}
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <i class="ri-building-4-line text-orange-500 text-xl"></i>
                    {{ $selectedOffer->name }}
                </h2>
                <span class="text-sm bg-orange-100 text-orange-600 font-semibold px-3 py-1 rounded-full shadow-sm">
                    <i class="ri-money-dollar-circle-line"></i> {{ number_format($selectedOffer->price, 2) }} د.ج
                </span>
            </div>
        
            {{-- الموقع --}}
            <div class="text-sm text-slate-500 flex items-center gap-2">
                <i class="ri-map-pin-line text-orange-400 text-lg"></i>
                {{ $selectedOffer->location }}
            </div>
        
            {{-- الوصف --}}
            <div class="text-sm text-slate-600 leading-relaxed border-t pt-3">
                {!! nl2br(e($selectedOffer->description)) !!}
            </div>
        </div>
    @endif

    @if ($step == 1)
    <div class="mb-6">
        <label for="branch" class="block text-sm font-medium text-gray-700 mb-2">اختر الفرع</label>

        @if ($selectedOffer->type === "services" && $branch->isNotEmpty())
            <select wire:model.lazy="selectedBranch" id="branch" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-orange-500 focus:border-orange-500">
                <option value="">-- اختر فرعاً --</option>
                @foreach ($branch as $branche)
                    <option value="{{ $branche->id }}">{{ $branche->name }}</option>
                @endforeach
            </select>
        @else
            <div class="text-red-500 font-semibold">لا يوجد فروع متاحة حالياً.</div>
        @endif
    </div>

    @if ($branchDetails)
        <div class="p-4 bg-gray-100 rounded-lg shadow-sm">
            <h3 class="text-lg font-bold mb-2">بيانات الفرع</h3>
            <p><strong>الاسم:</strong> {{ $branchDetails->name }}</p>
            <p><strong>الموقع:</strong> {{ $branchDetails->location }}</p>
        </div>
    @endif
@endif



    @if ($step == 2)
            @if ($selectedOffer->type == 'events')
                @php
                    $currentDate = isset($calendarDate) ? \Carbon\Carbon::parse($calendarDate) : now();
                    $startOfMonth = $currentDate->copy()->startOfMonth();
                    $endOfMonth = $currentDate->copy()->endOfMonth();
                    $firstDayOfWeek = $startOfMonth->dayOfWeek;
                    $daysInMonth = $currentDate->daysInMonth;
                    $rangeStart = \Carbon\Carbon::parse($times['data'][0]['start_date']);
                    $rangeEnd = \Carbon\Carbon::parse($times['data'][0]['end_date']);
                    $today = now()->toDateString();
                @endphp

                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <button wire:click="previousMonth" class="text-slate-500 hover:text-orange-500 text-xl">
                            <i class="ri-arrow-left-s-line"></i>
                        </button>
                        <h3 class="text-lg font-semibold text-slate-800">
                            <i class="ri-calendar-line text-orange-500 text-xl"></i>
                            {{ $currentDate->format('F Y') }}
                        </h3>
                        <button wire:click="nextMonth" class="text-slate-500 hover:text-orange-500 text-xl">
                            <i class="ri-arrow-right-s-line"></i>
                        </button>
                    </div>

                    {{-- أسماء الأيام --}}
                    <div class="grid grid-cols-7 gap-2 text-center text-slate-500 font-medium text-sm">
                        <div>أحد</div>
                        <div>اثنين</div>
                        <div>ثلاثاء</div>
                        <div>أربعاء</div>
                        <div>خميس</div>
                        <div>جمعة</div>
                        <div>سبت</div>
                    </div>

                    {{-- تقويم الشهر --}}
                    <div class="grid grid-cols-7 gap-2 text-center text-sm">
                        @for ($i = 0; $i < $firstDayOfWeek; $i++)
                            <div></div> {{-- فراغات قبل أول يوم --}}
                        @endfor

                        @for ($day = 1; $day <= $daysInMonth; $day++)
                            @php
                                $date = $currentDate->copy()->day($day);
                                $dateString = $date->toDateString();
                                $inRange = $date->between($rangeStart, $rangeEnd);
                                $isToday = $dateString === $today;
                                $isSelected = isset($selectedDate) && $dateString === $selectedDate;
                            @endphp

                            @if ($inRange)
                                <button wire:click="selectDate('{{ $dateString }}')"
                                        class="py-2 rounded-xl border font-medium transition
                                        {{ $isSelected ? 'bg-orange-500 text-white border-orange-600' : ($isToday ? 'bg-orange-100 border-orange-300 text-slate-700' : 'bg-slate-100 hover:bg-orange-100 border-slate-200 text-slate-700') }}">
                                    {{ $day }}
                                </button>
                            @else
                                <div class="py-2 rounded-xl border border-slate-100 text-slate-300 line-through bg-gray-100 cursor-not-allowed">
                                    {{ $day }}
                                </div>
                            @endif
                        @endfor
                    </div>
                </div>
            @elseif ($selectedOffer->type == 'services')
                @php
                    $currentDate = isset($calendarDate) ? \Carbon\Carbon::parse($calendarDate) : now();
                    $startOfMonth = $currentDate->copy()->startOfMonth();
                    $endOfMonth = $currentDate->copy()->endOfMonth();
                    $firstDayOfWeek = $startOfMonth->dayOfWeek;
                    $daysInMonth = $currentDate->daysInMonth;
                    $today = now()->toDateString();
                    $maxDate = isset($times['max_reservation_date']) ? \Carbon\Carbon::parse($times['max_reservation_date']) : null;
            
                    $availableDays = array_filter($times['data'] ?? [], function ($day) {
                        return !empty($day['enabled']) && !empty($day['from']) && !empty($day['to']);
                    });
                    //dd($availableDays);
            
                    // تحويل أسماء الأيام من الإنجليزية إلى أرقام Carbon
                    $dayToCarbon = [
                        'sunday' => 0,
                        'monday' => 1,
                        'tuesday' => 2,
                        'wednesday' => 3,
                        'thursday' => 4,
                        'friday' => 5,
                        'saturday' => 6,
                    ];
                @endphp
            
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <button wire:click="previousMonth" class="text-slate-500 hover:text-orange-500 text-xl">
                            <i class="ri-arrow-left-s-line"></i>
                        </button>
                        <h3 class="text-lg font-semibold text-slate-800">
                            <i class="ri-calendar-line text-orange-500 text-xl"></i>
                            {{ $currentDate->format('F Y') }}
                        </h3>
                        <button wire:click="nextMonth" class="text-slate-500 hover:text-orange-500 text-xl">
                            <i class="ri-arrow-right-s-line"></i>
                        </button>
                    </div>
            
                    {{-- أسماء الأيام --}}
                    <div class="grid grid-cols-7 gap-2 text-center text-slate-500 font-medium text-sm">
                        <div>أحد</div>
                        <div>اثنين</div>
                        <div>ثلاثاء</div>
                        <div>أربعاء</div>
                        <div>خميس</div>
                        <div>جمعة</div>
                        <div>سبت</div>
                    </div>
            
                    {{-- تقويم الشهر --}}
                    <div class="grid grid-cols-7 gap-2 text-center text-sm">
                        @for ($i = 0; $i < $firstDayOfWeek; $i++)
                            <div></div> {{-- فراغات قبل أول يوم --}}
                        @endfor
            
                        @for ($day = 1; $day <= $daysInMonth; $day++)
                            @php
                                $date = $currentDate->copy()->day($day);
                                $dateString = $date->toDateString();
                                $isToday = $dateString === $today;
                                $isSelected = isset($selectedDate) && $dateString === $selectedDate;
                                $dayOfWeek = $date->dayOfWeek; // 0 (الأحد) إلى 6 (السبت)
            
                                $dayName = array_search($dayOfWeek, $dayToCarbon); // نحصل على اسم اليوم بالنص
                                $isDayAvailable = isset($availableDays[$dayName]);
            
                                $withinMaxDate = !$maxDate || $date->lte($maxDate);
                                $inFuture = $date->isSameDay(now()) || $date->isAfter(now());
                                $canReserve = $isDayAvailable && $inFuture && $withinMaxDate;
                            @endphp
            
                            @if ($canReserve)
                                <button wire:click="selectDate('{{ $dateString }}')"
                                        class="py-2 rounded-xl border font-medium transition
                                        {{ $isSelected ? 'bg-orange-500 text-white border-orange-600' : ($isToday ? 'bg-orange-100 border-orange-300 text-slate-700' : 'bg-slate-100 hover:bg-orange-100 border-slate-200 text-slate-700') }}">
                                    {{ $day }}
                                </button>
                            @else
                                <div class="py-2 rounded-xl border border-slate-100 text-slate-300 line-through bg-gray-100 cursor-not-allowed">
                                    {{ $day }}
                                </div>
                            @endif
                        @endfor
                    </div>
                </div>
            @endif
            
    @endif

@if ($step == 3)
    @php

        $dayName = Carbon\Carbon::parse($selectedDate)->locale('en')->dayName; // e.g. "Saturday"
        $dayName = strtolower($dayName); // Ensure match with array keys
        $minTime = '00:00';
        $maxTime = '23:59';

        if ($selectedOffer->type == 'events') {
            $minTime = $times['data'][0]['start_time'] ?? '00:00';
            $maxTime = $times['data'][0]['end_time'] ?? '23:59';
        } elseif ($selectedOffer->type == 'services' && isset($times['data'][$dayName])) {
            $minTime = $times['data'][$dayName]['from'] ?? '00:00';
            $maxTime = $times['data'][$dayName]['to'] ?? '23:59';
        }
    @endphp

    <div class="mt-4">
        <label for="selected_time" class="block text-sm font-medium text-gray-700">اختر الوقت:</label>
        <input
            type="time"
            id="selected_time"
            wire:model.defer="selectedTime"
            min="{{ $minTime }}"
            max="{{ $maxTime }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm"
        >
        <p class="text-xs text-gray-500 mt-1">من {{ $minTime }} إلى {{ $maxTime }}</p>
    </div>
@endif


@if ($step == 4)
    <div class="space-y-6">

        {{-- السعر الأساسي والستوك --}}
        <div class="flex justify-between items-center">
            <div class="text-lg font-semibold">
                السعر: {{ $price }} د.ج
            </div>
            <div class="text-sm text-gray-600">
                الكمية المتوفرة: {{ $stock }}
            </div>
        </div>

        {{-- التحكم في الكمية --}}
        <div class="flex items-center space-x-2 rtl:space-x-reverse">
            <button wire:click="decreaseQuantity"
                    class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                -
            </button>
            <input type="number" wire:model.lazy="quantity"
                   class="w-16 text-center border rounded p-1" min="1" max="{{ $stock }}">
            <button wire:click="increaseQuantity"
                    class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">
                +
            </button>
        </div>

        {{-- الكوبون --}}
        <div class="flex items-center space-x-2 rtl:space-x-reverse">
            <input type="text" wire:model.lazy="couponCode"
                   placeholder="أدخل كود الخصم"
                   class="flex-1 p-2 border rounded">
            <button wire:click="applyCoupon"
                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                تحقق
            </button>
        </div>

        {{-- السعر النهائي --}}
        <div class="text-xl font-bold text-right">
            السعر النهائي: {{ $finalPrice }} د.ج
        </div>

    </div>
@endif

@if ($step == 5)
    @foreach ($Qa as $index => $Q)
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-1">
                {{ $Q['question'] }}
            </label>
            <input type="text" wire:model.defer="Qa.{{ $index }}.answer"
                   class="w-full border px-3 py-2 rounded shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500"
                   placeholder="اكتب إجابتك هنا">
        </div>
    @endforeach
@endif

@if ($step == 6)
    @if ($this->is_ready())
        <div class="space-y-6 bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">مراجعة الحجز</h2>

            {{-- بيانات الفرع --}}
            <div>
                <h3 class="font-semibold text-gray-700">الفرع:</h3>
                <p>{{ $selectedBranchData['name'] ?? 'غير محدد' }}</p>
                <p class="text-sm text-gray-500">{{ $selectedBranchData['location'] ?? '' }}</p>
            </div>

            {{-- التاريخ والوقت --}}
            <div>
                <h3 class="font-semibold text-gray-700">التاريخ والوقت:</h3>
                <p>{{ $selectedDate }}</p>
                <p>{{ $selectedTime }}</p>
            </div>

            {{-- السعر والكمية --}}
            <div>
                <h3 class="font-semibold text-gray-700">السعر:</h3>
                <p>{{ $price }} دج x {{ $quantity }} = <strong>{{ $price * $quantity }} دج</strong></p>
            </div>

            {{-- الكوبون --}}
            @if ($coupon)
                <div>
                    <h3 class="font-semibold text-gray-700">الكوبون:</h3>
                    <p>تم تطبيق الكوبون <strong>{{ $couponCode }}</strong>، الخصم: {{ $discount }} دج</p>
                </div>
            @endif

            {{-- السعر النهائي --}}
            <div class="text-lg font-bold text-green-600">
                السعر النهائي: {{ $finalPrice }} دج
            </div>

            {{-- زر التأكيد --}}

        
        </div>
    @else
        <div class="text-center text-red-600 font-semibold py-10">
            لا يمكن عرض المعاينة حالياً، يرجى التأكد من إدخال جميع البيانات بشكل صحيح.
        </div>
    @endif
@endif


@if ($step == 7)
    <div class="flex flex-col items-center justify-center bg-white shadow-md rounded-lg p-10 space-y-6 text-center">
        {{-- الأيقونة --}}
        <div class="w-24 h-24 rounded-full bg-green-100 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>

        {{-- الرسالة --}}
        <h2 class="text-2xl font-bold text-green-700">تمت الإضافة بنجاح</h2>
        <p class="text-gray-600">تمت إضافة العرض إلى السلة بنجاح. يمكنك متابعة التسوق أو الانتقال إلى السلة لإتمام الحجز.</p>

        {{-- زر الانتقال --}}
        <div class="space-x-4">
            <a href="" class="inline-block bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">
                عروض أخرى
            </a>
            <a href="{{route("cart",1)}}" wire:navigate class="inline-block bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                الذهاب إلى السلة
            </a>
        </div>
    </div>
@endif
@if($step < 7)
    <div class="mt-6">
        <div class="flex justify-between gap-4">
            @if($step > 0)
            <button wire:click="stepBack"
                    class="w-full bg-gray-200 hover:bg-gray-300 text-slate-700 font-semibold py-2 rounded-xl transition">
                 رجوع <i class="ri-arrow-right-line"></i>
            </button>
            @endif
    
            @if($step != 6)
            <button wire:click="stepNext"
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 rounded-xl transition">
                    <i class="ri-arrow-left-line"></i> التالي 
            </button>
            @else
            <button wire:click="stepNext"
                    class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-2 rounded-xl transition">
                الحجز <i class="ri-check-double-line"></i>
            </button>
            @endif
        </div>
    </div>
@endif    
   </div>

</div> 
@endif

    
</div>
