<div class="max-w-7xl mx-auto bg-white rounded-xl shadow-lg p-6 space-y-6">

    <div class="flex justify-between align-center">
        <!-- Title -->
        <div>
            <div class="text-lg font-bold text-gray-800">
                هل ترغب بنشر الخدمة؟
            </div>
            <p class="text-slate-500 text-xs">عند تعديل اي حقل يتم ازالة الخدمة من المتجر حتى تقوم بنشرها مجدداً
            </p>
        </div>
        <div>
            <div class="mb-3">
                <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                    <div class="bg-lime-500 h-4 text-xs font-medium text-white text-center leading-4"
                        style="width: {{ $percent_progress }}%;">
                        {{ number_format($percent_progress, 2) }}%
                    </div>
                </div>
            </div>
            <!-- Publish Button -->
            <div>
                @if ($isPublished == 'active')
                    <button
                        class="w-full bg-gray-300 text-gray-500 font-semibold py-2 px-6 rounded-lg cursor-not-allowed shadow"
                        disabled>
                        تم النشر
                    </button>
                @else
                    @if ($isReady)
                        <button wire:click="publish"
                            class="w-full bg-orange-500 text-white font-semibold py-2 px-6 rounded-lg shadow hover:bg-orange-600 transition">
                            نشر الخدمة
                        </button>
                    @else
                        <button
                            class="w-full bg-gray-300 text-gray-500 font-semibold py-2 px-6 rounded-lg cursor-not-allowed shadow"
                            disabled>
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
            'time' => 'أوقات الحجز',
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

            <div x-show="isOpen" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95" class="mt-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach ($fileds_exists as $field => $isCompleted)
                        <div
                            class="flex items-center gap-3 p-3 rounded-lg border transition-colors
                            {{ $isCompleted ? 'border-green-200 bg-green-50' : 'border-gray-200 bg-gray-50' }}">
                            <div class="flex-shrink-0">
                                @if ($isCompleted)
                                    <i class="ri-check-circle-fill text-green-500 text-xl"></i>
                                @else
                                    <i class="ri-close-circle-line text-gray-400 text-xl"></i>
                                @endif
                            </div>
                            <span
                                class="text-sm font-medium
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
