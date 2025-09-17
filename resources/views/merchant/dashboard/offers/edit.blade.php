@extends('merchant.layouts.app', ['merchant' => $merchantid ?? false])
@section('content')
    <!-- <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> -->


    @livewire('merchant.dashboard.offers.create.status', ['offering' => $offering, 'finalID' => $finalID])
    <div>

            <div class="mt-4 max-w-7xl mx-auto bg-white rounded-xl shadow-lg p-6 space-y-6" x-data="{ loadingStep: null }">
                <h2 class="text-2xl font-bold text-slate-800">تعديل الخدمة</h2>

                <div class="grid grid-cols-12 gap-6">
                    {{-- خطوات التسجيل - السلم --}}
                    {{-- <div class="grid grid-cols-12 gap-6"> --}}
                    {{-- خطوات التسجيل - السلم --}}
                    @livewire('merchant.dashboard.offers.setup-steps', ['offering' => $offering, 'merchantid' => $merchantid, 'finalID' => $finalID, 'currentStep' => $currentStep])


                    {{-- نموذج تعبئة المعلومات --}}

                    <div class="col-span-12 sm:col-span-8">
                        @if ($currentStep == 1)
                            @livewire('merchant.dashboard.offers.create.information', ['offering' => $offering, 'finalID' => $finalID])
                        @elseif ($currentStep == 3)
                            @livewire('merchant.dashboard.offers.create.res_settings', ['offering' => $offering, 'finalID' => $finalID])
                        @elseif ($currentStep == 4)
                            @livewire('merchant.dashboard.offers.create.time', ['offering' => $offering, 'finalID' => $finalID])
                        @elseif ($currentStep == 5)
                            @livewire('merchant.dashboard.offers.create.gallery', ['offering' => $offering, 'finalID' => $finalID])
                        @elseif ($currentStep == 6)
                            @livewire('merchant.dashboard.offers.create.offer-pricing', ['offering' => $offering, 'finalID' => $finalID])
                        @elseif ($currentStep == 7)
                            @livewire('merchant.dashboard.offers.create.faqs', ['offering' => $offering, 'finalID' => $finalID])
                        @elseif ($currentStep == 2)
                            @livewire('merchant.dashboard.offers.create.offer_settings', ['offering' => $offering, 'finalID' => $finalID])
                        @endif
                    </div>
                </div>
            </div>
    </div>




    <script>
        const hasChairsCheckbox = document.getElementById('hasChairs');
        const chairsCountContainer = document.getElementById('chairsCountContainer');

        hasChairsCheckbox.addEventListener('change', function() {
            chairsCountContainer.style.display = this.checked ? 'block' : 'none';
        });
    </script>
@endsection
