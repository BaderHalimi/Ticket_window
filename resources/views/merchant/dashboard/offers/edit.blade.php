@extends('merchant.layouts.app')
@section('content')
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

@php
    $currentStep = 1;
@endphp

<div class="flex-1 p-8">
    <div class="max-w-6xl mx-auto bg-white rounded-xl shadow-lg p-6 space-y-6">
        <h2 class="text-2xl font-bold text-slate-800">تعديل الخدمة</h2>

        <div class="grid grid-cols-12 gap-6">
            {{-- خطوات التسجيل - السلم --}}
            <div class="col-span-3">
                @livewire('merchant.dashboard.offers.setup-steps', ['currentStep' => $currentStep])
            </div>

            {{-- نموذج تعبئة المعلومات --}}
  
            
            <div class="col-span-9">
                @livewire('merchant.dashboard.offers.create.gallery', ['offering' => $offering])

             {{-- @livewire('merchant.dashboard.offers.create.prices', ['offering' => $offering]) --}}

                {{-- @livewire('merchant.dashboard.offers.create.res_settings', ['offering' => $offering]) --}}

                {{-- @if ($currentStep === 1)
                    @livewire('merchant.dashboard.offers.create.information', ['offering' => $offering])
                @elseif ($currentStep === 2)
                    @livewire('merchant.dashboard.offers.steps.step-two-settings')
                @elseif ($currentStep === 3)
                    @livewire('merchant.dashboard.offers.steps.step-three-gallery')
                @endif --}}
            </div>

        </div>
    </div>
</div>



<script>
    const hasChairsCheckbox = document.getElementById('hasChairs');
    const chairsCountContainer = document.getElementById('chairsCountContainer');

    hasChairsCheckbox.addEventListener('change', function () {
        chairsCountContainer.style.display = this.checked ? 'block' : 'none';
    });
</script>

@endsection
