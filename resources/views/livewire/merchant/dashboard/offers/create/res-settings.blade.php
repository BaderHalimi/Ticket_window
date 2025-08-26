<form wire:change="saveTimeSettings">
    <div class="space-y-6">

        {{-- {{ __('Booking Duration Settings') }} --}}
        @if ($offering->type == "services")

        <div>
            <div class="grid grid-cols-2 gap-4 mt-4">
                <!-- {{ __('Booking Duration') }} -->
                <div>
                    <label class="block text-sm font-medium mb-1">
                        {{ __('Booking Duration') }} <span class="text-red-500" style="font-weight: bold;">*</span>
                    </label>
                    <input type="number"
                           wire:model.lazy="booking_duration"
                           class="w-full border rounded-md p-2 focus:outline-none focus:ring focus:border-blue-300 @error('booking_duration') border-red-500 @enderror"
                           min="1"
                           max="1440"
                           placeholder="{{ __('Enter duration') }}">
                    @error('booking_duration')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">
                        {{ __('Duration for each booking slot (1-1440 minutes or 1-24 hours)') }}
                    </p>
                </div>

                <!-- {{ __('Time Unit') }} -->
                <div>
                    <label class="block text-sm font-medium mb-1">
                        {{ __('Time Unit') }}
                    </label>
                    <select wire:model.lazy="booking_unit"
                            class="w-full border rounded-md p-2 focus:outline-none focus:ring focus:border-blue-300 @error('booking_unit') border-red-500 @enderror">
                        <option value="hour">{{ __('Hour') }}</option>
                        <option value="minute">{{ __('Minute') }}</option>
                    </select>
                    @error('booking_unit')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">
                        {{ __('Select time unit for booking duration') }}
                    </p>
                </div>
            </div>

        </div>

        {{-- {{ __('User Interval Settings') }} --}}
        {{-- <div>
            <div class="flex items-center justify-between">
                <label class="text-sm font-medium">{{ __('Set time between bookings for user?') }}</label>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model.lazy="enable_user_interval" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md transform peer-checked:translate-x-full transition-all"></div>
                </label>
            </div>
            @if ($enable_user_interval)
                <div class="mt-2">
                    <label class="block text-sm font-medium mb-1">{{ __('Interval Between Bookings') }}</label>
                    <input type="number"
                           wire:model.lazy="user_interval_minutes"
                           class="w-full border rounded-md p-2 focus:outline-none focus:ring focus:border-blue-300 @error('user_interval_minutes') border-red-500 @enderror"
                           min="0"
                           max="1440"
                           placeholder="{{ __('Enter minutes') }}">
                    @error('user_interval_minutes')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">
                        {{ __('Minimum time between bookings for the same user (0-1440 minutes)') }}
                    </p>
                </div>
            @endif
        </div>

        {{ __('Global Interval Settings') }}
        <div>
            <div class="flex items-center justify-between">
                <label class="text-sm font-medium">{{ __('Set time between bookings for service?') }}</label>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model.lazy="enable_global_interval" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md transform peer-checked:translate-x-full transition-all"></div>
                </label>
            </div>
            @if ($enable_global_interval)
                <div class="mt-2">
                    <label class="block text-sm font-medium mb-1">{{ __('Interval Between Bookings') }}</label>
                    <input type="number"
                           wire:model.lazy="global_interval_minutes"
                           class="w-full border rounded-md p-2 focus:outline-none focus:ring focus:border-blue-300 @error('global_interval_minutes') border-red-500 @enderror"
                           min="0"
                           max="1440"
                           placeholder="{{ __('Enter minutes') }}">
                    @error('global_interval_minutes')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">
                        {{ __('Minimum time between any bookings for this service (0-1440 minutes)') }}
                    </p>
                </div>
            @endif
        </div> --}}

        {{-- {{ __('Work Schedule Settings') }} --}}
        @if ($type == 'restaurant')

        <div>
            <div class="flex items-center justify-between">
                <label class="text-sm font-medium">{{ __('Set work days and hours?') }}</label>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model.lazy="enable_work_schedule" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md transform peer-checked:translate-x-full transition-all"></div>
                </label>
            </div>
            @if ($enable_work_schedule)
            <div class="mt-4 grid grid-cols-1 gap-4">
                @php
                    $days = [
                        'saturday' => __('Saturday'),
                        'sunday' => __('Sunday'),
                        'monday' => __('Monday'),
                        'tuesday' => __('Tuesday'),
                        'wednesday' => __('Wednesday'),
                        'thursday' => __('Thursday'),
                        'friday' => __('Friday'),
                    ];
                @endphp

                @foreach ($days as $key => $label)
                    <div class="border rounded-md p-4 space-y-2">
                        <div class="flex items-center justify-between">
                            <label class="font-semibold">{{ $label }}</label>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model.lazy="work_schedule.{{ $key }}.enabled" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                                <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md transform peer-checked:translate-x-full transition-all"></div>
                            </label>
                        </div>

                        @if ($work_schedule[$key]['enabled'])
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="text-sm font-medium mb-1">{{ __('Start Time') }}</label>
                                    <input type="time"
                                           wire:model.lazy="work_schedule.{{ $key }}.start"
                                           class="w-full border rounded-md p-2 focus:outline-none focus:ring focus:border-blue-300 @error('work_schedule.'.$key.'.start') border-red-500 @enderror">
                                    @error('work_schedule.'.$key.'.start')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                    <p class="text-xs text-gray-500 mt-1">{{ __('Select opening time') }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium mb-1">{{ __('End Time') }}</label>
                                    <input type="time"
                                           wire:model.lazy="work_schedule.{{ $key }}.end"
                                           class="w-full border rounded-md p-2 focus:outline-none focus:ring focus:border-blue-300 @error('work_schedule.'.$key.'.end') border-red-500 @enderror">
                                    @error('work_schedule.'.$key.'.end')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                    <p class="text-xs text-gray-500 mt-1">{{ __('Select closing time') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif


        </div>
        @endif

        {{-- {{ __('Closed Days Settings') }} --}}
        @if ($type == 'restaurant')

<div>
    <div class="flex items-center justify-between">
        <label class="text-sm font-medium">{{ __('Closed days (holidays, etc.)?') }}</label>
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" wire:model.lazy="enable_closed_days" class="sr-only peer">
            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
            <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md transform peer-checked:translate-x-full transition-all"></div>
        </label>
    </div>

    @if ($enable_closed_days)
        <div class="mt-4 space-y-3">
            <label class="block text-sm font-medium mb-1"></label>
                {{ __('Closed Days') }}
            </label>

            {{-- {{ __('Add new date') }} --}}
            <div class="flex items-center gap-2">
                <input type="date"
                       wire:model.lazy="new_closed_day"
                       class="w-full border rounded-md p-2 focus:outline-none focus:ring focus:border-blue-300 @error('new_closed_day') border-red-500 @enderror"
                       min="{{ date('Y-m-d') }}">
                <button type="button"
                        wire:click="addClosedDay"
                        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                    {{ __('Add') }}
                </button>
            </div>
            @error('new_closed_day')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
            <p class="text-xs text-gray-500 mt-1">
                {{ __('Add dates when the restaurant will be closed (holidays, maintenance, etc.)') }}
            </p>

            {{-- {{ __('Current closed days') }} --}}
            @if (!empty($closed_days))
                <ul class="space-y-1">
                    @foreach ($closed_days as $index => $day)
                        <li class="flex items-center justify-between border p-2 rounded-md bg-gray-50">
                            <span>{{ \Carbon\Carbon::parse($day)->format('Y-m-d') }}</span>
                            <button type="button"
                                    wire:click="removeClosedDay({{ $index }})"
                                    class="text-red-600 hover:text-red-800"
                                    title="{{ __('Delete') }}">
                                {{ __('Delete') }}
                            </button>
                        </li>
                    @endforeach
                </ul>
            @endif

        </div>
    @endif
</div>
@endif
        {{-- Toggle: عدد المستخدمين المسموح به لكل حجز --}}
        <div>
            <div class="flex items-center justify-between">
                <label class="text-sm font-medium">{{ __('Set user count per service?') }}</label>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model.lazy="enable_user_limit" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md transform peer-checked:translate-x-full transition-all"></div>
                </label>
            </div>
            @if ($enable_user_limit)
                <div class="mt-2">
                    <label class="block text-sm font-medium mb-1">{{ __('Allowed Count') }}</label>
                    <input type="number"
                           wire:model.lazy="user_limit"
                           class="w-full border rounded-md p-2 focus:outline-none focus:ring focus:border-blue-300 @error('user_limit') border-red-500 @enderror"
                           min="1"
                           max="1000"
                           placeholder="{{ __('Enter user limit') }}">
                    @error('user_limit')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">
                        {{ __('Maximum number of users allowed per service (1-1000)') }}
                    </p>
                </div>
            @endif
        </div>

        @endif

        @if ($offering->type == "services")
        <div>
            <div class="flex items-center justify-between">
                <div class="space-y-2">
                    <label class="text-sm font-medium block">
                        {{ __('Maximum number of people who can book at the same time?') }}
                    </label>

                    <p class="text-sm text-gray-500">
                        {{ __('When this feature is enabled, you can set a maximum number of people who can book in the same time unit. For example: If the limit is set to 10 people per minute, no additional person can book in that minute if the maximum is reached, and they will have to wait until the minute ends and the quantity is renewed.') }}
                    </p>
                </div>
            </div>
            <div class="mt-2 space-y-2">
                <div>
                    <label class="block text-sm font-medium mb-1">{{ __('Allowed Count') }}</label>
                    <input type="number"
                           wire:model.lazy="max_user_time"
                           class="w-full border rounded-md p-2 focus:outline-none focus:ring focus:border-blue-300 @error('max_user_time') border-red-500 @enderror"
                           min="1"
                           max="10000"
                           placeholder="{{ __('Enter maximum users') }}">
                    @error('max_user_time')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">
                        {{ __('Maximum number of users allowed per time unit (1-10000)') }}
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">{{ __('Time Unit') }}</label>
                    <select wire:model.lazy="max_user_unit"
                            class="w-full border rounded-md p-2 focus:outline-none focus:ring focus:border-blue-300 @error('max_user_unit') border-red-500 @enderror">
                        <option value="minute">{{ __('Minute') }}</option>
                        <option value="hour">{{ __('Hour') }}</option>
                        <option value="day">{{ __('Day') }}</option>
                        <option value="week">{{ __('Week') }}</option>
                    </select>
                    @error('max_user_unit')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">
                        {{ __('Select time unit for user limit') }}
                    </p>
                </div>
            </div>


        </div>
        @elseif ($offering->type == "events")
        <div class="flex items-center justify-between">
            <div class="space-y-2">
                <label class="text-sm font-medium block">
                    {{ __('Maximum number of people who can join?') }}
                </label>
                <div>
                    <label class="block text-sm font-medium mb-1">{{ __('Allowed Count') }}</label>
                    <input type="number"
                           wire:model.lazy="eventMaxQuantity"
                           class="w-full border rounded-md p-2 focus:outline-none focus:ring focus:border-blue-300 @error('eventMaxQuantity') border-red-500 @enderror"
                           min="1"
                           max="100000"
                           placeholder="{{ __('Enter maximum participants') }}">
                    @error('eventMaxQuantity')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">
                        {{ __('Maximum number of participants allowed for this event (1-100000)') }}
                    </p>
                </div>
            </div>
        </div>

        @endif



        {{-- {{ __('Booking Deadline Settings') }} --}}
        <div>
            <div class="flex items-center justify-between">
                <label class="text-sm font-medium">{{ __('Set booking deadline before start?') }}</label>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model.lazy="enable_booking_deadline" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md transform peer-checked:translate-x-full transition-all"></div>
                </label>
            </div>
            @if ($enable_booking_deadline)
                <div class="mt-2">
                    <label class="block text-sm font-medium mb-1">{{ __('Minutes Before Start') }}</label>
                    <input type="number"
                           wire:model.lazy="booking_deadline_minutes"
                           class="w-full border rounded-md p-2 focus:outline-none focus:ring focus:border-blue-300 @error('booking_deadline_minutes') border-red-500 @enderror"
                           min="0"
                           max="10080"
                           placeholder="{{ __('Enter minutes') }}">
                    @error('booking_deadline_minutes')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">
                        {{ __('Number of minutes before start when booking should close (0-10080 minutes = 1 week)') }}
                    </p>
                </div>
            @endif
        </div>

        {{-- Toggle: تفعيل التكرار (مثل جلسات أسبوعية) --}}
        {{-- <div>
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
        </div> --}}

        {{-- Toggle: السماح للعميل بتحديد وقت البداية والنهاية بنفسه --}}
        {{-- <div>
            <div class="flex items-center justify-between">
                <label class="text-sm font-medium">السماح للعميل باختيار وقت البداية والنهاية؟</label>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model.lazy="enable_client_time_selection" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md transform peer-checked:translate-x-full transition-all"></div>
                </label>
            </div>
        </div> --}}
        
@if ($offering->type == "services" && ($offering->features["center"] ?? null) == "place")
<div>
    <div class="mt-4 space-y-3">
        <label class="block text-sm font-medium mb-1">{{ __('Select branches that offer this service:') }}</label>
        <div class="border rounded-md p-3 bg-white shadow-sm space-y-2 max-h-64 overflow-y-auto">
            @if(count($branches) > 0)
                @foreach ($branches as $branch)
                    <label class="flex items-center space-x-2">
                        <input
                            type="checkbox"
                            wire:model.lazy="selected_branches"
                            value="{{ $branch->id }}"
                            class="form-checkbox text-blue-600 rounded focus:ring-blue-500 @error('selected_branches') border-red-500 @enderror"
                        >
                        <span class="text-sm ml-16"> {{ $branch->name }}</span>
                    </label>
                @endforeach
            @else
                <p class="text-gray-500 text-sm">{{ __('No branches available') }}</p>
            @endif
        </div>
        @error('selected_branches')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
        <p class="text-xs text-gray-500 mt-1">
            {{ __('Select at least one branch where this service will be available') }}
        </p>
    </div>
</div>
@endif




    </div>
</form>

