<div class="flex-1 p-8">
    <div class="max-w-6xl mx-auto bg-white rounded-xl shadow-lg p-6 space-y-6">
        <h2 class="text-2xl font-bold text-slate-800">تعديل الخدمة</h2>

        <div class="grid grid-cols-12 gap-6">
            {{-- خطوات التسجيل - السلم --}}
            <div class="col-span-4 space-y-2 text-sm text-slate-700">
                @php
                    $steps = [
                        1 => ['title' => 'معلومات الحجز', 'desc' => 'تفاصيل الحجز الأساسية', 'icon' => 'ri-file-info-line'],
                        2 => ['title' => 'إعدادات الحجز', 'desc' => 'قواعد الحجز والتوفر', 'icon' => 'ri-settings-3-line'],
                        3 => ['title' => 'معرض الصور', 'desc' => 'صور المنتج', 'icon' => 'ri-image-line'],
                        4 => ['title' => 'التسعير', 'desc' => 'تفاصيل الأسعار', 'icon' => 'ri-money-dollar-circle-line'],
                        5 => ['title' => 'الأسئلة', 'desc' => 'تفاصيل اكثر', 'icon' => 'ri-money-dollar-circle-line'],
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
            <div class="col-span-8">
                @if ($currentStep === 1)
                    @livewire('merchant.dashboard.offers.create.information', ['offering' => $offering], key('info-'.$offering->id))
                @elseif ($currentStep === 2)
                    @livewire('merchant.dashboard.offers.create.res_settings', ['offering' => $offering], key('settings-'.$offering->id))
                @elseif ($currentStep === 3)
                    @livewire('merchant.dashboard.offers.create.gallery', ['offering' => $offering], key('gallery-'.$offering->id))
                @elseif ($currentStep === 4)
                    @livewire('merchant.dashboard.offers.create.prices', ['offering' => $offering], key('prices-'.$offering->id))
                @elseif ($currentStep === 5)
                    @livewire('merchant.dashboard.offers.create.faqs', ['offering' => $offering], key('faqs-'.$offering->id))
                      
                @endif
            </div>
        </div>
    </div>
</div>
