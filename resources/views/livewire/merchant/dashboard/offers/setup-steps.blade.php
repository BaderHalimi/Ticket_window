
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
                    {{-- setTimeout(() => {
                        $wire.setStep({{ $step }});
                        loadingStep = null;
                    }, 500); --}}
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
                {{-- <div class="col-span-12 sm:col-span-8">
                    @if ($currentStep === 1)
                    @livewire('merchant.dashboard.offers.create.information', ['offering' => $offering ,  "finalID" => $finalID])
                    @elseif ($currentStep === 3)
                    @livewire('merchant.dashboard.offers.create.res_settings', ['offering' => $offering ,  "finalID" => $finalID])
                    @elseif ($currentStep === 4)
                    @livewire('merchant.dashboard.offers.create.time', ['offering' => $offering ,  "finalID" => $finalID])
                    @elseif ($currentStep === 5)
                    @livewire('merchant.dashboard.offers.create.gallery', ['offering' => $offering ,  "finalID" => $finalID])
                    @elseif ($currentStep === 6)
                    @livewire('merchant.dashboard.offers.create.prices', ['offering' => $offering])
                    @elseif ($currentStep === 7)
                    @livewire('merchant.dashboard.offers.create.faqs', ['offering' => $offering ,  "finalID" => $finalID])
                    @elseif ($currentStep === 2)
                    @livewire('merchant.dashboard.offers.create.offer_settings', ['offering' => $offering ,  "finalID" => $finalID])

                    @endif
                </div> --}}
