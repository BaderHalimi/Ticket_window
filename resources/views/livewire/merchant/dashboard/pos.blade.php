<div class="flex justify-center mt-8">
    <div class="w-full max-w-4xl bg-white rounded-2xl shadow-xl p-10 space-y-8" dir="rtl">
        <h2 class="text-3xl font-bold text-center text-slate-800">نظام البيع الداخلي - إنشاء حجز</h2>

        {{-- اختيار الخدمة --}}
        <div>
            <label class="block mb-2 text-base font-medium text-slate-700">نوع الخدمة</label>
            <select wire:model.lazy="selectedOfferingId"
                    class="w-full rounded-lg border border-slate-300 px-4 py-3 text-base focus:ring-2 focus:ring-orange-500">
                <option value="">اختر الخدمة...</option>
                @foreach($offerings as $offering)
                    <option value="{{ $offering->id }}">{{ $offering->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- اختيار الباقة --}}
        @if(count($pricingPackages))
            <div>
                <label class="block mb-2 text-base font-medium text-slate-700">اختر الباقة</label>
                <select wire:model.lazy="selectedPackage"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 text-base focus:ring-2 focus:ring-orange-500">
                    <option value="">اختر باقة معينة</option>
                    @foreach($pricingPackages as $package)
                        <option value="{{ $package['label'] }}">
                            {{ $package['label'] }} - {{ $package['price'] }} ريال
                        </option>
                    @endforeach
                </select>
            </div>
        @endif

        {{-- إذا لم يختَر باقة -> أدخل الكمية والسعر يدوياً --}}
        @if(!$selectedPackage)
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-2 text-base font-medium text-slate-700">عدد التذاكر / الأشخاص</label>
                    <input type="number" wire:model.lazy="tickets" min="1"
                           class="w-full rounded-lg border border-slate-300 px-4 py-3 text-base focus:ring-2 focus:ring-orange-500">
                </div>
                <div>
                    <label class="block mb-2 text-base font-medium text-slate-700">السعر</label>
                    <input type="number" wire:model.lazy="manualPrice" min="0"
                           class="w-full rounded-lg border border-slate-300 px-4 py-3 text-base focus:ring-2 focus:ring-orange-500">
                </div>
            </div>
        @else
            <div class="bg-slate-100 p-4 rounded-lg text-slate-800 text-lg">
                <strong>السعر:</strong>
                @php
                    $pkg = collect($pricingPackages)->firstWhere('label', $selectedPackage);
                @endphp
                {{ $pkg['price'] ?? 0 }} ريال
            </div>
        @endif

        {{-- اختيار طريقة الدفع --}}
        <div>
            <label class="block mb-2 text-base font-medium text-slate-700">طريقة الدفع</label>
            <select wire:model.lazy="paymentMethod"
                    class="w-full rounded-lg border border-slate-300 px-4 py-3 text-base focus:ring-2 focus:ring-orange-500">
                <option value="">اختر طريقة الدفع</option>
                <option value="cash">نقدًا عند الحضور</option>
                <option value="vip">VIP</option>
                <option value="free">مجاني</option>
            </select>
        </div>

        {{-- إدخال البريد وعرض بيانات المستخدم --}}
        <div>
            <label class="block mb-2 text-base font-medium text-slate-700">البريد الإلكتروني (اختياري)</label>
            <input type="email" wire:model.lazy="customerEmail"
                   class="w-full rounded-lg border border-slate-300 px-4 py-3 text-base focus:ring-2 focus:ring-orange-500"
                   placeholder="email@example.com">
        </div>

        @if($foundUser)
            <div class="flex items-center gap-4 bg-slate-50 border p-4 rounded-lg">
                <img src="{{ $foundUser['profile_image'] ?? '/default-avatar.png' }}"
                     alt="صورة المستخدم"
                     class="w-16 h-16 rounded-full object-cover border">
                <div>
                    <div class="text-lg font-bold">{{ $foundUser['name'] }}</div>
                    <div class="text-slate-500">{{ $foundUser['email'] }}</div>
                </div>
            </div>
        @endif

        {{-- اسم الزبون ورقم الجوال --}}
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label class="block mb-2 text-base font-medium text-slate-700">اسم الزبون</label>
                <input type="text" wire:model.lazy="customerName"
                       class="w-full rounded-lg border border-slate-300 px-4 py-3 text-base focus:ring-2 focus:ring-orange-500"
                       placeholder="مثال: خالد محمد">
            </div>
            <div>
                <label class="block mb-2 text-base font-medium text-slate-700">رقم الجوال</label>
                <input type="text" wire:model.lazy="customerPhone"
                       class="w-full rounded-lg border border-slate-300 px-4 py-3 text-base focus:ring-2 focus:ring-orange-500"
                       placeholder="05xxxxxxxx">
            </div>
        </div>

        {{-- زر الإنشاء --}}
        <button wire:click="createBooking"
                class="w-full bg-orange-500 hover:bg-orange-600 text-white rounded-lg px-6 py-3 text-lg font-bold focus:ring-2 focus:ring-orange-500">
            إنشاء الحجز
        </button>

        {{-- رسالة نجاح --}}
        @if (session()->has('success'))
            <div class="bg-green-100 text-green-800 text-base rounded-lg p-4 text-center">
                {{ session('success') }}
            </div>
        @endif
    </div>
</div>
