<div class="flex justify-center mt-8">
    <div class="w-full max-w-4xl bg-white rounded-2xl shadow-xl p-10 space-y-8" dir="rtl">
        <h2 class="text-3xl font-bold text-center text-slate-800">نظام البيع الداخلي - إنشاء حجز</h2>

        {{-- اختيار الخدمة --}}
        <div>
            <label class="block mb-2">نوع الخدمة</label>
            <select wire:model.lazy="selectedOfferingId" class="w-full rounded-lg border border-slate-300 px-4 py-3">
                <option value="">اختر الخدمة...</option>
                @foreach($offerings as $offering)
                    <option value="{{ $offering->id }}">{{ $offering->name }}</option>
                @endforeach
            </select>
        </div>

        @if($selectedOfferingId)

            {{-- التاريخ --}}
            @if(count($allowedDates))
            <div>
                <label class="block mb-2">تاريخ الحجز</label>
                <select wire:model.lazy="selectedDate" class="w-full rounded-lg border border-slate-300 px-4 py-3">
                    <option value="">اختر تاريخ</option>
                    @foreach($allowedDates as $date)
                        <option value="{{ $date }}">{{ $date }}</option>
                    @endforeach
                </select>
            </div>
            @endif

            {{-- الوقت --}}
            @if($selectedDate && isset($allowedTimes[$selectedDate]))
            <div>
                <label class="block mb-2">وقت الحجز</label>
                <input type="time" wire:model.lazy="selectedTime"
                       min="{{ $allowedTimes[$selectedDate]['start'] }}"
                       max="{{ $allowedTimes[$selectedDate]['end'] }}"
                       class="w-full rounded-lg border border-slate-300 px-4 py-3">
                <p class="text-sm text-slate-500 mt-1">
                    الوقت المسموح: {{ $allowedTimes[$selectedDate]['start'] }} - {{ $allowedTimes[$selectedDate]['end'] }}
                </p>
            </div>
            @endif

            {{-- toggle slide للباقة --}}
            @if(count($pricingPackages))
            <div class="flex items-center justify-between mt-4">
                <span class="text-sm font-medium">تفعيل الباقة</span>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model.lazy="showPackage" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 rounded-full peer-checked:bg-orange-500 peer-focus:ring-2 peer-focus:ring-orange-300 transition duration-300"></div>
                    <div class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full shadow transition duration-300 peer-checked:translate-x-5"></div>
                </label>
            </div>
            @endif

            {{-- الباقات (تظهر فقط لو مفعّل toggle) --}}
            @if($showPackage)
            <div class="mt-4">
                <label class="block mb-2">اختر الباقة</label>
                <select wire:model.lazy="selectedPackage" class="w-full rounded-lg border border-slate-300 px-4 py-3">
                    <option value="">اختر باقة</option>
                    @foreach($pricingPackages as $package)
                        <option value="{{ $package['label'] }}">
                            {{ $package['label'] }} - {{ $package['price'] }} ريال
                        </option>
                    @endforeach
                </select>
            </div>
            @endif

            {{-- عدد الأشخاص (يختفي لو الباقة مفعّلة) --}}
            @if(!$showPackage)
            <div class="mt-4">
                <label class="block mb-2">عدد التذاكر / الأشخاص</label>
                <input type="number" wire:model.lazy="tickets" min="1"
                       class="w-full rounded-lg border border-slate-300 px-4 py-3">
            </div>
            @endif

            {{-- طريقة الدفع --}}
            <div class="mt-4">
                <label class="block mb-2">طريقة الدفع</label>
                <select wire:model.lazy="paymentMethod" class="w-full rounded-lg border border-slate-300 px-4 py-3">
                    <option value="">اختر طريقة الدفع</option>
                    <option value="cash">نقدًا عند الحضور</option>
                    <option value="free">مجاني</option>
                </select>
            </div>

            {{-- السعر (يظهر فقط لو الدفع نقداً + ما في باقة) --}}
            @if($paymentMethod === 'cash' && !$showPackage)
            <div class="mt-4">
                <label class="block mb-2">السعر</label>
                <input type="number" wire:model.lazy="manualPrice" min="0"
                       class="w-full rounded-lg border border-slate-300 px-4 py-3">
            </div>
            @endif

            <div class="mt-4">
                <label class="block mb-2">البريد الإلكتروني</label>
                <input type="email" wire:model.lazy="customerEmail"
                       class="w-full rounded-lg border border-slate-300 px-4 py-3"
                       placeholder="email@example.com">
            </div>

            @if($foundUser)
            <div class="flex items-center gap-4 bg-slate-100 p-4 rounded-lg mt-2">
                <img src="{{ Storage::url($foundUser['profile_image']) }}" class="w-12 h-12 rounded-full">
                <div>
                    <div class="font-bold">{{ $foundUser['name'] }}</div>
                    <div class="text-slate-500">{{ $foundUser['email'] }}</div>
                </div>
            </div>
            @endif

            {{-- الاسم والجوال --}}
            @if($customerEmail)
            <div class="grid grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block mb-2">اسم الزبون</label>
                    <input type="text" wire:model.lazy="customerName"
                           class="w-full rounded-lg border border-slate-300 px-4 py-3">
                </div>
                <div>
                    <label class="block mb-2">رقم الجوال</label>
                    <input type="text" wire:model.lazy="customerPhone"
                           class="w-full rounded-lg border border-slate-300 px-4 py-3"
                           placeholder="05xxxxxxxx">
                </div>
            </div>
            @endif

            <button wire:click="createBooking"
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white rounded-lg py-3 font-bold mt-4">
                إنشاء الحجز
            </button>

            @if (session()->has('success'))
            <div class="bg-green-100 text-green-800 rounded-lg p-4 text-center mt-4">
                {{ session('success') }}
            </div>
            @endif

            @if (session()->has('error'))
            <div class="bg-red-100 text-red-800 rounded-lg p-4 text-center mt-4">
                {{ session('error') }}
            </div>
            @endif

        @endif
    </div>
</div>
