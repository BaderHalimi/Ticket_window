<div class="space-y-8 p-6 bg-gradient-to-br from-gray-50 to-white rounded-xl shadow-sm">

    {{-- عرض الأخطاء العامة --}}
    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-r-lg">
            <div class="flex items-center mb-2">
                <i class="ri-error-warning-line mr-2 text-lg"></i>
                <h4 class="font-bold">{{ __('Please fix the following errors:') }}</h4>
            </div>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li class="text-sm">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="space-y-8">

        {{-- السعر الأساسي --}}
        <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
            <div class="flex items-center mb-4">
                <i class="ri-money-dollar-circle-line text-2xl text-green-600 mr-3"></i>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">{{ __('Base Price') }}</h3>
                    <p class="text-sm text-gray-600">{{ __('Set the main price for your offering') }}</p>
                </div>
            </div>

            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="ri-money-dollar-line text-gray-400"></i>
                </div>
                <input type="number"
                       step="0.01"
                       min="0"
                       max="999999.99"
                       wire:model.lazy="base_price"
                       placeholder="{{ __('Enter base price') }}"
                       class="w-full pl-10 pr-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 @error('base_price') border-red-500 ring-2 ring-red-200 @else border-gray-300 @enderror">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <span class="text-gray-500 text-sm">{{ __('SAR') }}</span>
                </div>
            </div>

            @error('base_price')
                <div class="mt-2 p-2 bg-red-100 border border-red-300 text-red-700 rounded-lg flex items-center">
                    <i class="ri-error-warning-line mr-2"></i>
                    <span class="text-sm">{{ $message }}</span>
                </div>
            @enderror

            <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex items-start">
                    <i class="ri-information-line text-blue-600 mr-2 mt-0.5"></i>
                    <div class="text-sm text-blue-700">
                        <p class="font-medium mb-1">{{ __('Pricing Tips:') }}</p>
                        <ul class="space-y-1 text-xs">
                            <li>• {{ __('Research competitor prices in your area') }}</li>
                            <li>• {{ __('Consider your costs and desired profit margin') }}</li>
                            <li>• {{ __('You can always adjust prices later') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- الخصم --}}
        <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <i class="ri-discount-percent-line text-2xl text-orange-600 mr-3"></i>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">{{ __('Discount') }}</h3>
                        <p class="text-sm text-gray-600">{{ __('Optional discount to attract more customers') }}</p>
                    </div>
                </div>
                <div class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                    {{ __('Optional') }}
                </div>
            </div>

            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="ri-percent-line text-gray-400"></i>
                </div>
                <input type="number"
                       step="0.01"
                       min="0"
                       max="100"
                       wire:model.lazy="discount"
                       placeholder="{{ __('Enter discount percentage') }}"
                       class="w-full pl-10 pr-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 @error('discount') border-red-500 ring-2 ring-red-200 @else border-gray-300 @enderror">
                <!-- <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <span class="text-gray-500 text-sm">%</span>
                </div> -->
            </div>

            @error('discount')
                <div class="mt-2 p-2 bg-red-100 border border-red-300 text-red-700 rounded-lg flex items-center">
                    <i class="ri-error-warning-line mr-2"></i>
                    <span class="text-sm">{{ $message }}</span>
                </div>
            @enderror

            @if($discount && $base_price)
                <div class="mt-4 p-4 bg-gradient-to-r from-green-50 to-blue-50 border border-green-200 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">{{ __('Price after discount:') }}</p>
                            <p class="text-2xl font-bold text-green-600">
                                {{ number_format($base_price - ($base_price * $discount / 100), 2) }} {{ __('SAR') }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500 line-through">{{ number_format($base_price, 2) }} {{ __('SAR') }}</p>
                            <p class="text-sm font-medium text-orange-600">{{ $discount }}% {{ __('OFF') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="mt-3 p-3 bg-orange-50 border border-orange-200 rounded-lg">
                <div class="flex items-start">
                    <i class="ri-lightbulb-line text-orange-600 mr-2 mt-0.5"></i>
                    <div class="text-sm text-orange-700">
                        <p class="font-medium mb-1">{{ __('Discount Tips:') }}</p>
                        <ul class="space-y-1 text-xs">
                            <li>• {{ __('Limited-time discounts create urgency') }}</li>
                            <li>• {{ __('Consider seasonal or promotional discounts') }}</li>
                            <li>• {{ __('Track which discounts work best for your business') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    {{-- توجل: التسعير بالساعات --}}
    {{-- <div>
        <div class="flex items-center justify-between">
            <label class="text-sm font-medium">تفعيل التسعير بالساعات؟</label>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" wire:model.lazy="enable_hourly_pricing" class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow transform peer-checked:translate-x-full transition-all"></div>
            </label>
        </div>
        @if ($enable_hourly_pricing)
            <div class="mt-2">
                <label class="block text-sm font-medium mb-1">السعر لكل ساعة</label>
                <input type="number" step="0.01" wire:model.lazy="hourly_rate" class="w-full border rounded-md p-2">
            </div>
        @endif
    </div> --}}

        {{-- الكوبونات --}}
        <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <i class="ri-coupon-3-line text-2xl text-indigo-600 mr-3"></i>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">{{ __('Discount Coupons') }}</h3>
                        <p class="text-sm text-gray-600">{{ __('Create promotional codes for your customers') }}</p>
                    </div>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model.lazy="enable_coupons" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:bg-indigo-600 transition-all"></div>
                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md transform peer-checked:translate-x-full transition-all"></div>
                </label>
            </div>

            @if ($enable_coupons)
                <div class="space-y-6">
                    {{-- عرض الكوبونات الموجودة --}}
                    @if(count($coupons) > 0)
                        <div class="space-y-4">
                            <h4 class="text-sm font-medium text-gray-700 flex items-center">
                                <i class="ri-ticket-2-line mr-2 text-indigo-600"></i>
                                {{ __('Active Coupons') }} ({{ count($coupons) }})
                            </h4>

                            @foreach ($coupons as $index => $coupon)
                                <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl p-6 border border-indigo-200 shadow-sm" wire:key="coupon-{{ $index }}">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                                {{ $index + 1 }}
                                            </div>
                                            <div class="ml-3">
                                                <h5 class="font-bold text-gray-800">{{ __('Coupon') }} #{{ $index + 1 }}</h5>
                                                <p class="text-xs text-gray-600">{{ __('Promotional discount code') }}</p>
                                            </div>
                                        </div>
                                        <button type="button"
                                                wire:click="removeCoupon({{ $index }})"
                                                class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-full transition-colors duration-200 shadow-md hover:shadow-lg"
                                                title="{{ __('Delete Coupon') }}">
                                            <i class="ri-delete-bin-line text-sm"></i>
                                        </button>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        {{-- كود الكوبون --}}
                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                                <i class="ri-barcode-line mr-1 text-indigo-600"></i>
                                                {{ __('Coupon Code') }} <span class="text-red-500">*</span>
                                            </label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <i class="ri-hashtag text-gray-400"></i>
                                                </div>
                                                <input type="text"
                                                       wire:model.lazy="coupons.{{ $index }}.code"
                                                       placeholder="{{ __('Enter coupon code (e.g., SAVE20)') }}"
                                                       class="w-full pl-10 pr-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('coupons.'.$index.'.code') border-red-500 ring-red-200 @else border-gray-300 @enderror">
                                            </div>
                                            @error('coupons.'.$index.'.code')
                                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                                    <i class="ri-error-warning-line mr-1"></i>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                            <p class="text-xs text-gray-500 mt-1 flex items-center">
                                                <i class="ri-information-line mr-1"></i>
                                                {{ __('Use uppercase letters, numbers, hyphens and underscores only') }}
                                            </p>
                                        </div>

                                        {{-- نوع الخصم --}}
                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                                <i class="ri-percent-line mr-1 text-indigo-600"></i>
                                                {{ __('Discount Type') }} <span class="text-red-500">*</span>
                                            </label>
                                            <div class="relative">
                                                <select wire:model.lazy="coupons.{{ $index }}.type"
                                                        class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('coupons.'.$index.'.type') border-red-500 ring-2 ring-red-200 @else border-gray-300 @enderror">
                                                    <option value="">{{ __('Select discount type') }}</option>
                                                    <option value="percentage">{{ __('Percentage (%)') }}</option>
                                                    <option value="fixed">{{ __('Fixed Amount (SAR)') }}</option>
                                                </select>
                                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                    <i class="ri-arrow-down-s-line text-gray-400"></i>
                                                </div>
                                            </div>
                                            @error('coupons.'.$index.'.type')
                                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                                    <i class="ri-error-warning-line mr-1"></i>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                            <p class="text-xs text-gray-500 mt-1 flex items-center">
                                                <i class="ri-information-line mr-1"></i>
                                                {{ __('Choose how the discount will be calculated') }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                        {{-- قيمة الخصم --}}
                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                                <i class="ri-money-dollar-circle-line mr-1 text-indigo-600"></i>
                                                {{ __('Discount Value') }} <span class="text-red-500">*</span>
                                            </label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    @if(isset($coupon['type']) && $coupon['type'] === 'percentage')
                                                        <i class="ri-percent-line text-gray-400"></i>
                                                    @else
                                                        <i class="ri-money-dollar-line text-gray-400"></i>
                                                    @endif
                                                </div>
                                                <input type="number"
                                                       step="0.01"
                                                       min="0.01"
                                                       max="{{ isset($coupon['type']) && $coupon['type'] === 'percentage' ? '100' : '99999.99' }}"
                                                       wire:model.lazy="coupons.{{ $index }}.discount"
                                                       placeholder="{{ isset($coupon['type']) && $coupon['type'] === 'percentage' ? __('Enter percentage (1-100)') : __('Enter amount in SAR') }}"
                                                       class="w-full pl-10 pr-16 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('coupons.'.$index.'.discount') border-red-500 ring-2 ring-red-200 @else border-gray-300 @enderror">
                                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500 text-sm">
                                                        {{ isset($coupon['type']) && $coupon['type'] === 'percentage' ? '%' : __('SAR') }}
                                                    </span>
                                                </div>
                                            </div>
                                            @error('coupons.'.$index.'.discount')
                                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                                    <i class="ri-error-warning-line mr-1"></i>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                            <p class="text-xs text-gray-500 mt-1 flex items-center">
                                                <i class="ri-information-line mr-1"></i>
                                                @if(isset($coupon['type']) && $coupon['type'] === 'percentage')
                                                    {{ __('Percentage discount from the total price') }}
                                                @else
                                                    {{ __('Fixed amount to be deducted from the total') }}
                                                @endif
                                            </p>
                                        </div>

                                        {{-- تاريخ انتهاء الصلاحية --}}
                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                                <i class="ri-calendar-event-line mr-1 text-indigo-600"></i>
                                                {{ __('Expiry Date') }}
                                            </label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <i class="ri-calendar-line text-gray-400"></i>
                                                </div>
                                                <input type="date"
                                                       wire:model.lazy="coupons.{{ $index }}.expires_at"
                                                       min="{{ now()->addDay()->toDateString() }}"
                                                       max="{{ now()->addYears(2)->toDateString() }}"
                                                       class="w-full pl-10 pr-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('coupons.'.$index.'.expires_at') border-red-500 ring-2 ring-red-200 @else border-gray-300 @enderror">
                                            </div>
                                            @error('coupons.'.$index.'.expires_at')
                                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                                    <i class="ri-error-warning-line mr-1"></i>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                            <p class="text-xs text-gray-500 mt-1 flex items-center">
                                                <i class="ri-information-line mr-1"></i>
                                                {{ __('Leave empty for no expiry date') }}
                                            </p>
                                        </div>
                                    </div>

                                    {{-- معاينة الكوبون --}}
                                    @if(isset($coupon['code']) && isset($coupon['discount']) && isset($coupon['type']))
                                        <div class="mt-6 p-4 bg-white rounded-lg border-2 border-dashed border-indigo-300">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <div class="bg-indigo-600 text-white px-3 py-1 rounded-full text-sm font-bold">
                                                        {{ $coupon['code'] }}
                                                    </div>
                                                    <div class="ml-3">
                                                        <p class="text-sm font-medium text-gray-800">
                                                            {{ __('Save') }}
                                                            @if($coupon['type'] === 'percentage')
                                                                {{ $coupon['discount'] }}%
                                                            @else
                                                                {{ number_format($coupon['discount'], 2) }} {{ __('SAR') }}
                                                            @endif
                                                        </p>
                                                        @if(isset($coupon['expires_at']) && $coupon['expires_at'])
                                                            <p class="text-xs text-gray-500">
                                                                {{ __('Valid until') }} {{ \Carbon\Carbon::parse($coupon['expires_at'])->format('M d, Y') }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <i class="ri-coupon-3-line text-2xl text-indigo-600"></i>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <i class="ri-coupon-3-line text-4xl mb-3 text-gray-300"></i>
                            <p class="text-lg font-medium">{{ __('No coupons created yet') }}</p>
                            <p class="text-sm">{{ __('Create your first promotional coupon') }}</p>
                        </div>
                    @endif

                    {{-- زر إضافة كوبون جديد --}}
                    <div class="flex justify-center pt-4 border-t border-gray-200">
                        <button type="button"
                                wire:click="addCoupon"
                                class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 flex items-center gap-2 shadow-md hover:shadow-lg transform hover:scale-105">
                            <i class="ri-add-line text-lg"></i>
                            {{ __('Add New Coupon') }}
                        </button>
                    </div>
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="ri-coupon-3-line text-4xl mb-3 text-gray-300"></i>
                    <p class="text-lg font-medium">{{ __('Coupons Disabled') }}</p>
                    <p class="text-sm">{{ __('Enable coupons to create promotional discount codes') }}</p>
                </div>
            @endif

            {{-- نصائح الكوبونات --}}
            <div class="mt-6 p-4 bg-indigo-50 border border-indigo-200 rounded-lg">
                <div class="flex items-start">
                    <i class="ri-lightbulb-line text-indigo-600 mr-2 mt-0.5"></i>
                    <div class="text-sm text-indigo-700">
                        <p class="font-medium mb-2">{{ __('Coupon Tips:') }}</p>
                        <ul class="space-y-1 text-xs">
                            <li>• {{ __('Use memorable and relevant coupon codes') }}</li>
                            <li>• {{ __('Set reasonable expiry dates to create urgency') }}</li>
                            <li>• {{ __('Track which coupons perform best') }}</li>
                            <li>• {{ __('Consider percentage vs fixed discounts based on your pricing') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- الخصومات المجدولة --}}
        <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <i class="ri-calendar-event-line text-2xl text-emerald-600 mr-3"></i>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">{{ __('Scheduled Discounts') }}</h3>
                        <p class="text-sm text-gray-600">{{ __('Automatically apply a discount during a specific period') }}</p>
                    </div>
                </div>
                <label class="relative inline-flex items-center cursor-pointer toggle-switch">
                    <input type="checkbox" wire:model.lazy="enable_discounts" class="sr-only peer">
                    <div class="w-12 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-300 rounded-full peer peer-checked:bg-gradient-to-r peer-checked:from-emerald-600 peer-checked:to-green-600 transition-all duration-300"></div>
                    <div class="absolute left-1 top-1 w-5 h-5 bg-white rounded-full shadow-lg transform peer-checked:translate-x-5 transition-all duration-300 flex items-center justify-center">
                        <i class="ri-check-line text-xs text-emerald-600 opacity-0 peer-checked:opacity-100 transition-opacity duration-200"></i>
                    </div>
                </label>
            </div>

            @if ($enable_discounts)
                <div class="space-y-6">
                    {{-- معلومات الخصم --}}
                    <div class="bg-gradient-to-r from-emerald-50 to-green-50 rounded-lg p-4 border border-emerald-200">
                        <div class="flex items-center mb-2">
                            <i class="ri-information-line text-emerald-600 mr-2"></i>
                            <h4 class="font-bold text-emerald-800">{{ __('Discount Information') }}</h4>
                        </div>
                        <p class="text-sm text-emerald-700">
                            {{ __('Set up automatic discounts that will be applied during specific time periods. This is perfect for flash sales, seasonal promotions, or special events.') }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        {{-- تاريخ البداية --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                <i class="ri-calendar-event-line mr-1 text-emerald-600"></i>
                                {{ __('Start Date and Time') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="ri-time-line text-gray-400"></i>
                                </div>
                                <input type="datetime-local"
                                       wire:model.lazy="discount_start"
                                       min="{{ now()->format('Y-m-d\TH:i') }}"
                                       max="{{ now()->addYears(2)->format('Y-m-d\TH:i') }}"
                                       class="w-full pl-10 pr-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200 @error('discount_start') border-red-500 ring-2 ring-red-200 @else border-gray-300 @enderror">
                            </div>
                            @error('discount_start')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="ri-error-warning-line mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1 flex items-center">
                                <i class="ri-information-line mr-1"></i>
                                {{ __('When the discount should start') }}
                            </p>
                        </div>

                        {{-- تاريخ النهاية --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                <i class="ri-calendar-check-line mr-1 text-emerald-600"></i>
                                {{ __('End Date and Time') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="ri-time-line text-gray-400"></i>
                                </div>
                                <input type="datetime-local"
                                       wire:model.lazy="discount_end"
                                       @if($discount_start) min="{{ \Carbon\Carbon::parse($discount_start)->addHour()->format('Y-m-d\TH:i') }}" @else min="{{ now()->addHour()->format('Y-m-d\TH:i') }}" @endif
                                       max="{{ now()->addYears(2)->format('Y-m-d\TH:i') }}"
                                       class="w-full pl-10 pr-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200 @error('discount_end') border-red-500 ring-2 ring-red-200 @else border-gray-300 @enderror">
                            </div>
                            @error('discount_end')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="ri-error-warning-line mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1 flex items-center">
                                <i class="ri-information-line mr-1"></i>
                                {{ __('When the discount should end') }}
                            </p>
                        </div>

                        {{-- نسبة الخصم --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                <i class="ri-percent-line mr-1 text-emerald-600"></i>
                                {{ __('Discount Percentage') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="ri-percent-line text-gray-400"></i>
                                </div>
                                <input type="number"
                                       min="1"
                                       max="100"
                                       step="0.01"
                                       wire:model.lazy="discount_percent"
                                       placeholder="{{ __('Enter discount percentage') }}"
                                       class="w-full pl-10 pr-16 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200 @error('discount_percent') border-red-500 ring-2 ring-red-200 @else border-gray-300 @enderror">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 text-sm">%</span>
                                </div>
                            </div>
                            @error('discount_percent')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="ri-error-warning-line mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1 flex items-center">
                                <i class="ri-information-line mr-1"></i>
                                {{ __('Percentage to discount from base price') }}
                            </p>
                        </div>
                    </div>

                    {{-- معاينة الخصم --}}
                    @if($discount_start && $discount_end && $discount_percent && $base_price)
                        @php
                            try {
                                $startDate = \Carbon\Carbon::parse($discount_start);
                                $endDate = \Carbon\Carbon::parse($discount_end);
                                $showPreview = true;
                            } catch (\Exception $e) {
                                $showPreview = false;
                            }
                        @endphp

                        @if($showPreview)
                            <div class="bg-gradient-to-r from-emerald-50 to-green-50 rounded-xl p-6 border-2 border-emerald-200 shadow-sm">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="font-bold text-emerald-800 mb-2 flex items-center">
                                            <i class="ri-flashlight-line mr-2"></i>
                                            {{ __('Discount Preview') }}
                                        </h4>
                                        <div class="space-y-2">
                                            <div class="flex items-center text-sm text-emerald-700">
                                                <i class="ri-calendar-line mr-2"></i>
                                                <span>{{ __('Active from') }} {{ $startDate->format('M d, Y H:i') }}</span>
                                            </div>
                                            <div class="flex items-center text-sm text-emerald-700">
                                                <i class="ri-calendar-check-line mr-2"></i>
                                                <span>{{ __('Until') }} {{ $endDate->format('M d, Y H:i') }}</span>
                                            </div>
                                            <div class="flex items-center text-sm text-emerald-700">
                                                <i class="ri-time-line mr-2"></i>
                                                <span>{{ __('Duration:') }} {{ $startDate->diffForHumans($endDate, true) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="bg-white rounded-lg p-4 shadow-sm border border-emerald-200">
                                            <p class="text-xs text-gray-600 mb-1">{{ __('Original Price') }}</p>
                                            <p class="text-sm text-gray-500 line-through">{{ number_format($base_price, 2) }} {{ __('SAR') }}</p>
                                            <p class="text-xs text-emerald-600 font-medium">{{ $discount_percent }}% {{ __('OFF') }}</p>
                                            <p class="text-lg font-bold text-emerald-600">
                                                {{ number_format($base_price - ($base_price * $discount_percent / 100), 2) }} {{ __('SAR') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif

                    {{-- نصائح الخصومات المجدولة --}}
                    <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <i class="ri-lightbulb-line text-emerald-600 mr-2 mt-0.5"></i>
                            <div class="text-sm text-emerald-700">
                                <p class="font-medium mb-2">{{ __('Scheduled Discount Tips:') }}</p>
                                <ul class="space-y-1 text-xs">
                                    <li>• {{ __('Plan discounts around holidays and special events') }}</li>
                                    <li>• {{ __('Use flash sales (short duration) to create urgency') }}</li>
                                    <li>• {{ __('Monitor performance and adjust future discounts accordingly') }}</li>
                                    <li>• {{ __('Combine with marketing campaigns for maximum impact') }}</li>
                                    <li>• {{ __('Consider your profit margins when setting discount percentages') }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="ri-calendar-event-line text-4xl mb-3 text-gray-300"></i>
                    <p class="text-lg font-medium">{{ __('Scheduled Discounts Disabled') }}</p>
                    <p class="text-sm">{{ __('Enable scheduled discounts to create time-limited promotional offers') }}</p>
                </div>
            @endif
        </div>


    {{-- توجل: السماح بالإلغاء --}}
    {{-- <div>
        <div class="flex items-center justify-between">
            <label class="text-sm font-medium">السماح بإلغاء الحجز؟</label>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" wire:model.lazy="enable_cancellation" class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow transform peer-checked:translate-x-full transition-all"></div>
            </label>
        </div>
    </div> --}}

    {{-- توجل: رسوم الإلغاء --}}
    <div>
        <div class="flex items-center justify-between">
            <label class="text-sm font-medium">تفعيل الالغاء ؟</label>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" wire:model.lazy="enable_cancellation" class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow transform peer-checked:translate-x-full transition-all"></div>
            </label>
        </div>
        @if ($enable_cancellation)
            <div class="mt-2">
                <label class="block text-sm font-medium mb-1">رسوم الالغاء (با المئة ) %</label>
                <input type="number" step="0.01" wire:model.lazy="cancellation_fee" class="w-full border rounded-md p-2">
            </div>
            <label class="text-sm font-medium">تحديد آخر وقت للإلغاء؟</label>

            <div class="mt-2">
                {{-- <label class="block text-sm font-medium mb-1">عدد الدقائق قبل البدء</label> --}}
                <input type="number" wire:model.lazy="cancellation_deadline_minutes" placeholder="عدد الدقائق قبل البدء" class="w-full border rounded-md p-2">
            </div>
        @endif

    </div>

    {{-- توجل: الأجل الأخير للإلغاء --}}
    {{-- <div>
        <div class="flex items-center justify-between">
            <label class="text-sm font-medium">تحديد آخر وقت للإلغاء؟</label>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" wire:model.lazy="enable_cancellation_deadline" class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow transform peer-checked:translate-x-full transition-all"></div>
            </label>
        </div>
        @if ($enable_cancellation_deadline)
            <div class="mt-2">
                <label class="block text-sm font-medium mb-1">عدد الدقائق قبل البدء</label>
                <input type="number" wire:model.lazy="cancellation_deadline_minutes" class="w-full border rounded-md p-2">
            </div>
        @endif
    </div> --}}

    {{-- توجل: تسعير حسب عدد الأشخاص --}}
    <div>
        <div class="flex items-center justify-between">
            <label class="text-sm font-medium">تفعيل الباقات ؟</label>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" wire:model.lazy="enable_pricing_packages" class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow transform peer-checked:translate-x-full transition-all"></div>
            </label>
        </div>
        @if ($enable_pricing_packages)
            <div class="mt-4 space-y-3">
                @foreach ($pricing_packages as $index => $pkg)
                    <div class="flex items-center gap-2">
                        <input type="text" wire:model.lazy="pricing_packages.{{ $index }}.label" placeholder="مثال: شخص واحد" class="flex-1 border p-2 rounded-md">
                        <input type="number" step="0.01" wire:model.lazy="pricing_packages.{{ $index }}.price" placeholder="السعر" class="w-32 border p-2 rounded-md">
                        <button type="button" wire:click="removePackage({{ $index }})" class="text-red-500 hover:underline text-sm">حذف</button>
                    </div>
                @endforeach
                <button type="button" wire:click="addPackage" class="text-blue-600 hover:underline text-sm">+ إضافة باقة</button>
            </div>
        @endif
    </div>

</form>
