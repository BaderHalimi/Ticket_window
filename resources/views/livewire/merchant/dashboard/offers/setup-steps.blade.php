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
                                {{ $percent_progress }}%
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



            <!-- Missing Fields Alert -->
            @php
            $missingFields = collect($fileds_exists)->filter(fn($v) => !$v);
            @endphp

            @if ($missingFields->isNotEmpty())
            <div class="font-semibold text-red-700 flex items-center gap-2">
                <i class="ri-error-warning-line text-xl"></i>
                هناك حقول ناقصة يجب إكمالها:
            </div>
            <div class="border border-red-300 bg-red-50 rounded-lg p-4 space-y-2">
                <ul class="list-disc list-inside text-red-600 space-y-1">
                    @foreach ($missingFields as $field => $exists)
                    <li class="flex items-center gap-2">
                        <i class="ri-close-circle-line text-red-500"></i>
                        <span>حقل "{{ $field }}" ناقص</span>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
            <!-- Progress Bar -->

        </div>
        <div class="mt-4 max-w-6xl mx-auto bg-white rounded-xl shadow-lg p-6 space-y-6">
            <h2 class="text-2xl font-bold text-slate-800">تعديل الخدمة</h2>

            <div class="grid grid-cols-12 gap-6">
                {{-- خطوات التسجيل - السلم --}}
                <div class="sm:col-span-4 col-span-12 sm:block flex overflow-x-scroll grid-cols-6 space-y-2 text-sm text-slate-700">
                    @php
                    $steps = [
                    1 => ['title' => 'معلومات الحجز', 'desc' => 'تفاصيل الحجز الأساسية', 'icon' => 'ri-file-info-line'],
                    2 => ['title' => 'إعدادات الحجز', 'desc' => 'قواعد الحجز والتوفر', 'icon' => 'ri-settings-3-line'],
                    3 => ['title' => 'وقت الحجز', 'desc' => 'تحديد الوقت للحجوزات', 'icon' => 'ri-time-line'],
                    4 => ['title' => 'معرض الصور', 'desc' => 'صور المنتج', 'icon' => 'ri-image-line'],
                    5 => ['title' => 'التسعير', 'desc' => 'تفاصيل الأسعار', 'icon' => 'ri-money-dollar-circle-line'],
                    6 => ['title' => 'الأسئلة', 'desc' => 'تفاصيل اكثر', 'icon' => 'ri-question-mark'],
                    ];
                    @endphp

                    @foreach ($steps as $step => $data)
                    <div
                        wire:click="setStep({{ $step }})"
                        class="flex items-start p-3 rounded-lg transition cursor-pointer
                            {{ $currentStep === $step ? 'border border-red-300 bg-red-50' : 'hover:bg-slate-50' }}">

                        <i class="{{ $data['icon'] }} text-xl mt-1 ml-2
                            {{ $currentStep === $step ? 'text-red-500' : 'text-slate-500' }}"></i>

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
                    @livewire('merchant.dashboard.offers.create.information', ['offering' => $offering], key('info-'.$offering->id))
                    @elseif ($currentStep === 2)
                    @livewire('merchant.dashboard.offers.create.res_settings', ['offering' => $offering], key('settings-'.$offering->id))
                    @elseif ($currentStep === 3)
                    @livewire('merchant.dashboard.offers.create.time', ['offering' => $offering], key('time-'.$offering->id))
                    @elseif ($currentStep === 4)
                    @livewire('merchant.dashboard.offers.create.gallery', ['offering' => $offering], key('gallery-'.$offering->id))
                    @elseif ($currentStep === 5)
                    @livewire('merchant.dashboard.offers.create.prices', ['offering' => $offering], key('prices-'.$offering->id))
                    @elseif ($currentStep === 6)
                    @livewire('merchant.dashboard.offers.create.faqs', ['offering' => $offering], key('faqs-'.$offering->id))

                    @endif
                </div>
            </div>
        </div>


    </div>


</div>
