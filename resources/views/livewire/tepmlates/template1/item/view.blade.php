<div class="max-w-7xl mx-auto grid grid-cols-1
@if ($selectedDate != null)
lg:grid-cols-3
@else
lg:grid-cols-2
@endif
 gap-6 py-10 px-4">

    <!-- تفاصيل العرض -->
    <div class="col-span-1">
        <img src="{{ Storage::url($offer->image ?? '/img/ad-placeholder.jpg') }}" alt="عرض" class="rounded-lg w-full h-40 object-cover">
        <h2 class="text-xl font-bold">{{ $offer->name }}</h2>
        <p class="text-sm text-gray-600">{{ $offer->description }}</p>

        <!-- <div class="border p-3 rounded">
            <p class="text-sm">التكلفة: <span class="font-semibold">{{ $offer->price }} ريال</span></p>
        </div> -->

        <!-- عدد الأشخاص -->
        <div class="flex items-center gap-2">
            <span>عدد:</span>
            <button wire:click="subNumber" class="px-3 py-1 border rounded">-</button>
            <input wire:model="count" type="text" class="w-10 text-center border rounded" value="1">
            <button wire:click="addNumber" class="px-3 py-1 border rounded">+</button>
        </div>

        <!-- السعر -->
        <div class="text-right mt-4">
            <!-- <p class="text-gray-500 line-through">{{ $offer->price }} ر.س</p> -->
            <p class="text-2xl font-bold text-orange-600">{{ $price }} ر.س</p>
        </div>
    </div>

    <!-- التقويم -->
    <div class="text-center">
        <!-- أزرار التنقل بين الشهور -->
        <div class="flex justify-between items-center mb-4">
            <button wire:click="prevMonth" class="px-3 py-1 bg-gray-100 rounded">الشهر السابق</button>
            <span class="text-xl font-bold">{{ $date->translatedFormat('F Y') }}</span>
            <button wire:click="nextMonth" class="px-3 py-1 bg-gray-100 rounded">الشهر التالي</button>
        </div>

        <div class="grid grid-cols-7 gap-2 text-sm">
            <div>سبت</div>
            <div>أحد</div>
            <div>إثنين</div>
            <div>ثلاثاء</div>
            <div>أربعاء</div>
            <div>خميس</div>
            <div>جمعة</div>

            @php
            $shift = ($firstDayIndex + 1) % 7;
            @endphp

            @for($i = 0; $i < $shift; $i++)
                <div>
        </div>
        @endfor

        @for($day = 1; $day <= $daysInMonth; $day++)
            @php
            $fullDate=\Carbon\Carbon::create($date->year, $date->month, $day)->toDateString();
            $isAvailable = in_array($fullDate, $availableDays);
            @endphp

            <button wire:click="selectDate({{ $day }})"
                class="p-2 rounded {{ $isAvailable ? (isset($selectedDate)&&Carbon\Carbon::parse($selectedDate)->format('d')==$day? 'bg-black text-white cursor-pointer' : 'bg-white hover:bg-black hover:text-white cursor-pointer') : 'bg-gray-200 text-gray-400 cursor-not-allowed' }}">
                {{ $day }}
            </button>
            @endfor
    </div>
</div>

<!-- أوقات الحجز -->
@if ($selectedDate != null)
<div class="col-span-1">
    <!-- <div class="flex gap-2">
        <button class="bg-black text-white px-3 py-1 rounded">12h</button>
        <button class="border px-3 py-1 rounded">24h</button>
    </div> -->

    <h3 class="font-bold text-lg mt-4">
        {{ $selectedDate ? \Carbon\Carbon::parse($selectedDate)->translatedFormat('l d') : 'اختر تاريخ أولاً' }}
    </h3>
    <div class="grid grid-cols-2 gap-2">
        @foreach($timeSlots as $i=>$time)
        <button wire:click="selectTime('{{ $time }}')" class="{{ $time==$selectedTime ? 'bg-black text-white': "hover:bg-gray-100" }} border px-4 py-2 rounded">{{ $time }}</button>
        @endforeach
    </div>
    <button class="mt-4 w-full bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-full font-bold">
        احجز الآن
    </button>

</div>
@endif

</div>
