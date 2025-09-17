<div>
    <div class="flex-1 p-8">
        <div class="max-w-7xl mx-auto bg-white rounded-xl shadow-lg p-6 space-y-6">

            <div class="flex justify-between align-center">
                <!-- Title -->
                <div>
                    <div class="text-lg font-bold text-gray-800">
                    هل ترغب بنشر الخدمة؟
                </div>
                <p class="text-slate-500 text-xs">عند تعديل اي حقل يتم ازالة الخدمة من المتجر حتى تقوم بنشرها مجدداً</p>
                </div>
                <div>
                    <div class="mb-3">
                        <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                            <div class="bg-lime-500 h-4 text-xs font-medium text-white text-center leading-4" style="width: {{ $percent_progress }}%;">
                                {{ number_format($percent_progress, 2) }}%
                            </div>
                        </div>
                    </div>
                    <!-- Publish Button -->
                    <div>
                        @if ($isPublished == 'active')
                        <button class="w-full bg-gray-300 text-gray-500 font-semibold py-2 px-6 rounded-lg cursor-not-allowed shadow" disabled>
                            تم النشر
                        </button>
                        @else
                        @if ($isReady)
                        <button wire:click="publish" class="w-full bg-orange-500 text-white font-semibold py-2 px-6 rounded-lg shadow hover:bg-orange-600 transition">
                            نشر الخدمة
                        </button>
                        @else
                        <button class="w-full bg-gray-300 text-gray-500 font-semibold py-2 px-6 rounded-lg cursor-not-allowed shadow" disabled>
                            لا يمكن النشر - أكمل البيانات
                        </button>
                        @endif
                        @endif
                    </div>
                </div>
            </div>



            <!-- Required Fields Status -->
            @php
            $fieldLabels = [
                'name' => 'اسم الخدمة',
                'description' => 'وصف الخدمة',
                'location' => 'الموقع',
                'image' => 'صورة الخدمة',
                'price' => 'السعر',
                'booking_duration' => 'مدة الحجز',
                'booking_unit' => 'وحدة الحجز',
                'user_limit' => 'حد المستخدمين',
                'branch' => 'الفرع',
                'center' => 'المركز',
                'time' => 'أوقات الحجز'
            ];
            @endphp

            @if (!empty($fileds_exists))
            <div class="bg-white border border-gray-200 rounded-lg p-4" x-data="{ isOpen: false }">
                <div class="font-semibold text-gray-800 flex items-center justify-between cursor-pointer"
                     @click="isOpen = !isOpen">
                    <div class="flex items-center gap-2">
                        <i class="ri-task-line text-xl"></i>
                        الحقول المطلوبة
                        @php
                        $completedCount = collect($fileds_exists)->filter(fn($v) => $v)->count();
                        $totalCount = count($fileds_exists);
                        @endphp
                        <span class="text-sm text-gray-500">
                            ({{ $completedCount }}/{{ $totalCount }})
                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="text-sm text-gray-500">
                            {{ $completedCount == $totalCount ? 'مكتمل' : 'غير مكتمل' }}
                        </div>
                        <i class="ri-arrow-down-s-line text-xl transition-transform duration-200"
                           :class="{ 'rotate-180': isOpen }"></i>
                    </div>
                </div>

                <div x-show="isOpen"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-95"
                     class="mt-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach ($fileds_exists as $field => $isCompleted)
                        <div class="flex items-center gap-3 p-3 rounded-lg border transition-colors
                            {{ $isCompleted ? 'border-green-200 bg-green-50' : 'border-gray-200 bg-gray-50' }}">
                            <div class="flex-shrink-0">
                                @if ($isCompleted)
                                    <i class="ri-check-circle-fill text-green-500 text-xl"></i>
                                @else
                                    <i class="ri-close-circle-line text-gray-400 text-xl"></i>
                                @endif
                            </div>
                            <span class="text-sm font-medium
                                {{ $isCompleted ? 'text-green-700' : 'text-gray-600' }}">
                                {{ $fieldLabels[$field] ?? $field }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            <!-- Progress Bar -->

        </div>
        <div class="mt-4 max-w-7xl mx-auto bg-white rounded-xl shadow-lg p-6 space-y-6" x-data="{ loadingStep: null }">
            <h2 class="text-2xl font-bold text-slate-800">تعديل الخدمة</h2>

            <div class="grid grid-cols-12 gap-6">
                {{-- خطوات التسجيل - السلم --}}
                <div class="sm:col-span-4 col-span-12 sm:block flex overflow-x-scroll grid-cols-6 space-y-2 text-sm text-slate-700">
                    @php
                    $steps = [
                    1 => ['title' => 'معلومات الحجز', 'desc' => 'تفاصيل الحجز الأساسية', 'icon' => 'ri-file-info-line'],
                    2 => ['title' => 'اعدادات العرض', 'desc' => 'تفاصيل العرض', 'icon' => 'ri-folder-settings-line'],
                    3 => ['title' => 'إعدادات الحجز', 'desc' => 'قواعد الحجز والتوفر', 'icon' => 'ri-settings-3-line'],
                    4 => ['title' => 'وقت الحجز', 'desc' => 'تحديد الوقت للحجوزات', 'icon' => 'ri-time-line'],
                    5 => ['title' => 'معرض الصور', 'desc' => 'صور المنتج', 'icon' => 'ri-image-line'],
                    6 => ['title' => 'التسعير', 'desc' => 'تفاصيل الأسعار', 'icon' => 'ri-money-dollar-circle-line'],
                    7 => ['title' => 'الأسئلة', 'desc' => 'تفاصيل اكثر', 'icon' => 'ri-question-mark'],
                    ];
                    @endphp
                    @foreach ($steps as $step => $data)
                    <div             @click.prevent="
                    loadingStep = {{ $step }};
                    setTimeout(() => {
                        $wire.setStep({{ $step }});
                        loadingStep = null;
                    }, 500);
                "
                        wire:click="setStep({{ $step }})"
                        class="flex items-start p-3 rounded-lg transition cursor-pointer
                            {{ $currentStep === $step ? 'border border-red-300 bg-red-50' : 'hover:bg-slate-50' }}">
                            <div class="w-6 h-6 mt-1 ml-2 flex items-center justify-center">
                                <template x-if="loadingStep === {{ $step }}">
                                    <svg class="animate-spin h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                              d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                    </svg>
                                </template>
                                <i x-show="loadingStep !== {{ $step }}" class="{{ $data['icon'] }} text-xl
                                    {{ $currentStep === $step ? 'text-red-500' : 'text-slate-500' }}"></i>
                            </div>

                        <div>
                            <div class="font-semibold {{ $currentStep === $step ? 'text-red-800' : 'text-slate-800' }}">
                                {{ $data['title'] }}
                            </div>
                            <div class="text-xs {{ $currentStep === $step ? 'text-red-600' : 'text-slate-500' }}">
                                {{ $data['desc'] }}
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>

                {{-- نموذج تعبئة المعلومات --}}
                <div class="col-span-12 sm:col-span-8">
                    @if ($currentStep === 1)
                    @livewire('merchant.dashboard.offers.create.information', ['offering' => $offering ,  "finalID" => $finalID], key('info-'.$offering->id))
                    @elseif ($currentStep === 3)
                    @livewire('merchant.dashboard.offers.create.res_settings', ['offering' => $offering ,  "finalID" => $finalID], key('settings-'.$offering->id))
                    @elseif ($currentStep === 4)
                    @livewire('merchant.dashboard.offers.create.time', ['offering' => $offering ,  "finalID" => $finalID], key('time-'.$offering->id))
                    @elseif ($currentStep === 5)
                    @livewire('merchant.dashboard.offers.create.gallery', ['offering' => $offering ,  "finalID" => $finalID], key('gallery-'.$offering->id))
                    @elseif ($currentStep === 6)
                    @livewire('merchant.dashboard.offers.create.prices', ['offering' => $offering , "finalID" => $finalID], key('prices-'.$offering->id))
                    @elseif ($currentStep === 7)
                    @livewire('merchant.dashboard.offers.create.faqs', ['offering' => $offering ,  "finalID" => $finalID], key('faqs-'.$offering->id))
                    @elseif ($currentStep === 2)
                    @livewire('merchant.dashboard.offers.create.offer_settings', ['offering' => $offering ,  "finalID" => $finalID], key('offer-'.$offering->id))

                    @endif
                </div>
            </div>
        </div>


    </div>


</div>
