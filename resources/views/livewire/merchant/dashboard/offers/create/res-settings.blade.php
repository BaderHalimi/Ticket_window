<form wire:change="saveTimeSettings">
    <div class="space-y-6">

        {{-- Toggle: تفعيل تحديد مدة الحجز --}}
        <div>
            <div class="flex items-center justify-between">
                <label class="text-sm font-medium">تحديد مدة الحجز؟</label>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model.lazy="enable_duration" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md transform peer-checked:translate-x-full transition-all"></div>
                </label>
            </div>
            @if ($enable_duration)
                <div class="grid grid-cols-2 gap-2 mt-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">مدة الحجز</label>
                        <input type="number" wire:model.lazy="booking_duration" class="w-full border rounded-md p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">الوحدة</label>
                        <select wire:model.lazy="booking_unit" class="w-full border rounded-md p-2">
                            <option value="hour">ساعة</option>
                            <option value="minute">دقيقة</option>
                        </select>
                    </div>
                </div>
            @endif
        </div>

        {{-- Toggle: الوقت بين كل حجز وآخر للمستخدم --}}
        <div>
            <div class="flex items-center justify-between">
                <label class="text-sm font-medium">الوقت بين كل حجز وآخر للمستخدم؟</label>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model.lazy="enable_user_interval" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md transform peer-checked:translate-x-full transition-all"></div>
                </label>
            </div>
            @if ($enable_user_interval)
                <div class="mt-2">
                    <label class="block text-sm font-medium mb-1">المدة بين الحجوزات</label>
                    <input type="number" wire:model.lazy="user_interval_minutes" class="w-full border rounded-md p-2">
                </div>
            @endif
        </div>

        {{-- Toggle: الوقت بين كل حجز وآخر للخدمة كاملة --}}
        <div>
            <div class="flex items-center justify-between">
                <label class="text-sm font-medium">الوقت بين كل حجز وآخر للخدمة؟</label>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model.lazy="enable_global_interval" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md transform peer-checked:translate-x-full transition-all"></div>
                </label>
            </div>
            @if ($enable_global_interval)
                <div class="mt-2">
                    <label class="block text-sm font-medium mb-1">المدة بين الحجوزات</label>
                    <input type="number" wire:model.lazy="global_interval_minutes" class="w-full border rounded-md p-2">
                </div>
            @endif
        </div>

        {{-- Toggle: تحديد أيام وأوقات العمل --}}
        <div>
            <div class="flex items-center justify-between">
                <label class="text-sm font-medium">تحديد أوقات وأيام العمل؟</label>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model.lazy="enable_work_schedule" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md transform peer-checked:translate-x-full transition-all"></div>
                </label>
            </div>
            @if ($enable_work_schedule)
                <div class="mt-2">
                    <label class="block text-sm font-medium mb-1">مثال: السبت إلى الخميس - من 9 صباحًا إلى 5 مساءً</label>
                    <input type="text" wire:model.lazy="work_schedule_notes" class="w-full border rounded-md p-2">
                </div>
            @endif
        </div>

        {{-- Toggle: أيام ممنوع العمل فيها --}}
        <div>
            <div class="flex items-center justify-between">
                <label class="text-sm font-medium">أيام مغلقة (مثل الأعياد)؟</label>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model.lazy="enable_closed_days" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md transform peer-checked:translate-x-full transition-all"></div>
                </label>
            </div>
            @if ($enable_closed_days)
                <div class="mt-2">
                    <label class="block text-sm font-medium mb-1">أدخل التواريخ (مفصولة بفواصل)</label>
                    <input type="text" wire:model.lazy="closed_days" class="w-full border rounded-md p-2">
                </div>
            @endif
        </div>

        {{-- Toggle: عدد المستخدمين المسموح به لكل حجز --}}
        <div>
            <div class="flex items-center justify-between">
                <label class="text-sm font-medium">عدد المستخدمين لكل حجز؟</label>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model.lazy="enable_user_limit" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md transform peer-checked:translate-x-full transition-all"></div>
                </label>
            </div>
            @if ($enable_user_limit)
                <div class="mt-2">
                    <label class="block text-sm font-medium mb-1">العدد المسموح</label>
                    <input type="number" wire:model.lazy="user_limit" class="w-full border rounded-md p-2">
                </div>
            @endif
        </div>

        {{-- Toggle: أقصى وقت للحجز قبل البداية --}}
        <div>
            <div class="flex items-center justify-between">
                <label class="text-sm font-medium">آخر وقت للحجز قبل البدء؟</label>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model.lazy="enable_booking_deadline" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md transform peer-checked:translate-x-full transition-all"></div>
                </label>
            </div>
            @if ($enable_booking_deadline)
                <div class="mt-2">
                    <label class="block text-sm font-medium mb-1">عدد الدقائق قبل البدء</label>
                    <input type="number" wire:model.lazy="booking_deadline_minutes" class="w-full border rounded-md p-2">
                </div>
            @endif
        </div>

        {{-- Toggle: تفعيل التكرار (مثل جلسات أسبوعية) --}}
        <div>
            <div class="flex items-center justify-between">
                <label class="text-sm font-medium">تفعيل التكرار (مثلاً جلسات أسبوعية)؟</label>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model.lazy="enable_weekly_recurrence" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md transform peer-checked:translate-x-full transition-all"></div>
                </label>
            </div>
            @if ($enable_weekly_recurrence)
                <div class="mt-2">
                    <label class="block text-sm font-medium mb-1">اختر أيام التكرار</label>
                    <input type="text" wire:model.lazy="weekly_recurrence_days" placeholder="مثل: السبت, الثلاثاء" class="w-full border rounded-md p-2">
                </div>
            @endif
        </div>

        {{-- Toggle: السماح للعميل بتحديد وقت البداية والنهاية بنفسه --}}
        <div>
            <div class="flex items-center justify-between">
                <label class="text-sm font-medium">السماح للعميل باختيار وقت البداية والنهاية؟</label>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model.lazy="enable_client_time_selection" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md transform peer-checked:translate-x-full transition-all"></div>
                </label>
            </div>
        </div>

    </div>
</form>
