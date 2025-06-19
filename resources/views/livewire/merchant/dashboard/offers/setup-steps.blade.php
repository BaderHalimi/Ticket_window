@php
$steps = [
    1 => ['title' => 'معلومات الحجز', 'desc' => 'تفاصيل الحجز الأساسية', 'icon' => 'ri-file-info-line'],
    2 => ['title' => 'إعدادات الحجز', 'desc' => 'قواعد الحجز والتوفر', 'icon' => 'ri-settings-3-line'],
    3 => ['title' => 'معرض الصور', 'desc' => 'صور المنتج', 'icon' => 'ri-image-line'],
];
@endphp

<div class="space-y-2 text-sm text-slate-700">
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
