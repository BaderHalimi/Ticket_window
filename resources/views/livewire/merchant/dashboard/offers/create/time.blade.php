<form wire:submit.prevent>
    <div class="space-y-4">

        {{-- <div>
            <label class="flex items-center gap-2">
                <input type="checkbox" wire:model="enable_time" class="form-checkbox">
                <span>تفعيل الوقت</span>
            </label>
        </div> --}}
        {{-- @dd($offering->type) --}}


        @if ($offering->type == 'services')
            <div class="border rounded-md p-4 space-y-4 bg-gradient-to-r from-blue-50 to-indigo-50">
                <h3 class="text-lg font-bold mb-3 text-gray-800 flex items-center">
                    <i class="ri-calendar-line mr-2 text-blue-600"></i>
                    {{ __('Default Day Settings') }}
                </h3>

                {{-- عرض الأخطاء العامة --}}
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-r-lg">
                        <div class="flex items-center mb-2">
                            <i class="ri-error-warning-line mr-2 text-lg"></i>
                            <h4 class="font-bold">{{ __('Please fix the following errors:') }}</h4>
                        </div>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="text-sm">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <div>
                        <label class="flex items-center gap-2 text-sm font-medium">
                            <input type="checkbox"
                                   wire:model.lazy="default_day.enabled"
                                   class="form-checkbox text-blue-600 rounded focus:ring-blue-500">
                            <span>{{ __('Enable Default') }}</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ __('Apply same time to all days') }}
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">{{ __('Start Time') }}</label>
                        <input type="time"
                               wire:model.lazy="default_day.from"
                               class="w-full border rounded-md p-2 focus:outline-none focus:ring focus:border-blue-300 @error('default_day.from') border-red-500 @enderror"
                               @if(!($default_day['enabled'] ?? false)) disabled @endif>
                        @error('default_day.from')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">
                            {{ __('Default opening time') }}
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">{{ __('End Time') }}</label>
                        <input type="time"
                               wire:model.lazy="default_day.to"
                               class="w-full border rounded-md p-2 focus:outline-none focus:ring focus:border-blue-300 @error('default_day.to') border-red-500 @enderror"
                               @if(!($default_day['enabled'] ?? false)) disabled @endif>
                        @error('default_day.to')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">
                            {{ __('Default closing time') }}
                        </p>
                    </div>

                    <div>
                        <button type="button"
                                wire:click="applyDefaultToAll"
                                class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
                                @if(!($default_day['enabled'] ?? false)) disabled @endif>
                            <i class="ri-check-double-line mr-1"></i>
                            {{ __('Apply to All') }}
                        </button>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ __('Apply default time to all days') }}
                        </p>
                    </div>
                </div>

                <h3 class="text-lg font-bold mb-3 text-gray-800 flex items-center">
                    <i class="ri-time-line mr-2 text-green-600"></i>
                    {{ __('Days and Times') }} <span class="text-red-500 ml-1">*</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @php
                        $dayNames = [
                            'saturday' => __('Saturday'),
                            'sunday' => __('Sunday'),
                            'monday' => __('Monday'),
                            'tuesday' => __('Tuesday'),
                            'wednesday' => __('Wednesday'),
                            'thursday' => __('Thursday'),
                            'friday' => __('Friday')
                        ];
                    @endphp

                    @foreach(['saturday','sunday','monday','tuesday','wednesday','thursday','friday'] as $dayName)
                        <div class="border rounded-lg p-4 bg-white shadow-sm hover:shadow-md transition {{ isset($day[$dayName]) && $day[$dayName] ? 'border-blue-300 bg-blue-50' : 'border-gray-200' }}" wire:key="day-{{ $dayName }}-{{ $offering->id }}">
                            <label class="flex items-center gap-2 mb-3 cursor-pointer">
                                <input type="checkbox"
                                       wire:model.lazy="day.{{ $dayName }}"
                                       class="form-checkbox text-blue-600 rounded focus:ring-blue-500">
                                <span class="font-medium text-gray-700">{{ $dayNames[$dayName] }}</span>
                            </label>

                            @if(!empty($day[$dayName]))
                                <div class="space-y-3 animate-fadeIn">
                                    <div>
                                        <label class="block text-sm font-medium mb-1 text-gray-600">{{ __('From') }}:</label>
                                        <input type="time"
                                               wire:model.lazy="from_time.{{ $dayName }}"
                                               class="w-full border rounded-md p-2 focus:outline-none focus:ring focus:border-blue-300 @error('from_time.'.$dayName) border-red-500 @enderror">
                                        @error('from_time.'.$dayName)
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ __('Opening time') }}
                                        </p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1 text-gray-600">{{ __('To') }}:</label>
                                        <input type="time"
                                               wire:model.lazy="to_time.{{ $dayName }}"
                                               class="w-full border rounded-md p-2 focus:outline-none focus:ring focus:border-blue-300 @error('to_time.'.$dayName) border-red-500 @enderror">
                                        @error('to_time.'.$dayName)
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ __('Closing time') }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                <div class="w-full border-t pt-4 mt-6">
                    <div class="w-full bg-gray-100 p-4 rounded-md flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h4 class="text-sm font-bold text-gray-700 mb-1">{{ __('Enable reservation end date') }}</h4>
                            <p class="text-sm text-gray-500">{{ __('Prevents booking after the specified date. Disable to allow unlimited booking dates.') }}</p>
                        </div>

                        <div class="flex items-center gap-3">
                            <span class="text-sm font-medium {{ $active_max_reservation_date ? 'text-blue-600' : 'text-gray-500' }}">
                                {{ $active_max_reservation_date ? __('Enabled') : __('Disabled') }}
                            </span>

                            <button type="button"
                                wire:click="$toggle('active_max_reservation_date')"
                                class="relative inline-flex items-center h-8 w-16 rounded-full transition-colors duration-300 ease-in-out
                                    {{ $active_max_reservation_date ? 'bg-blue-600' : 'bg-gray-300' }}">

                                <span class="absolute left-1 top-1 h-6 w-6 rounded-full bg-white shadow-md transform transition-transform duration-300 ease-in-out
                                    {{ $active_max_reservation_date ? 'translate-x-8' : 'translate-x-0' }}">
                                </span>
                            </button>
                        </div>
                    </div>




                @if ($active_max_reservation_date)
                    <div class="mt-4 p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                        <label class="flex items-center text-sm font-bold mb-2 text-gray-800">
                            <i class="ri-calendar-event-line mr-2 text-blue-600"></i>
                            {{ __('Maximum Reservation Date') }} <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input
                            type="date"
                            wire:model.lazy="max_reservation_date"
                            min="{{ now()->toDateString() }}"
                            max="{{ now()->addYears(5)->toDateString() }}"
                            class="w-full border rounded-md p-3 focus:outline-none focus:ring focus:border-blue-300 @error('max_reservation_date') border-red-500 @enderror"
                        >
                        @error('max_reservation_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-sm text-gray-500 mt-2 flex items-start">
                            <i class="ri-information-line mr-1 text-blue-500 mt-0.5"></i>
                            {{ __('Customers will not be able to book after this date until it is renewed') }}
                        </p>
                    </div>
                @endif
            </div>
        @endif

        {{-- {{ __('EVENTS') }} --}}
        @if ($offering->type == 'events')
            <div class="border rounded-lg p-6 space-y-6 bg-gradient-to-r from-purple-50 to-pink-50">
                <h3 class="text-lg font-bold mb-4 text-gray-800 flex items-center">
                    <i class="ri-calendar-event-line mr-2 text-purple-600"></i>
                    {{ __('Event Dates (From → To)') }} <span class="text-red-500 ml-1">*</span>
                </h3>

                {{-- عرض الأخطاء --}}
                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(count($calendar) > 0)
                    @foreach ($calendar as $index => $item)
                        <div class="border rounded-lg p-4 space-y-4 bg-white shadow-sm hover:shadow-md transition" wire:key="event-{{ $index }}-{{ $offering->id }}">
                            <div class="flex justify-between items-center">
                                <h4 class="font-medium text-gray-700 flex items-center">
                                    <i class="ri-calendar-2-line mr-2 text-blue-500"></i>
                                    {{ __('Event') }} #{{ $index + 1 }}
                                </h4>
                                <button type="button"
                                        wire:click="removeEvent({{ $index }})"
                                        class="text-red-600 hover:text-red-800 p-2 rounded-full hover:bg-red-50 transition"
                                        title="{{ __('Delete Event') }}">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium mb-1 text-gray-600">{{ __('Start Date') }}:</label>
                                    <input type="date"
                                           wire:model.lazy="calendar.{{ $index }}.start_date"
                                           class="w-full border rounded-md p-2 focus:outline-none focus:ring focus:border-blue-300 @error('calendar.'.$index.'.start_date') border-red-500 @enderror"
                                           min="{{ now()->toDateString() }}"
                                           max="{{ now()->addYears(5)->toDateString() }}">
                                    @error('calendar.'.$index.'.start_date')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ __('Event start date') }}
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1 text-gray-600">{{ __('End Date') }}:</label>
                                    <input type="date"
                                           wire:model.lazy="calendar.{{ $index }}.end_date"
                                           class="w-full border rounded-md p-2 focus:outline-none focus:ring focus:border-blue-300 @error('calendar.'.$index.'.end_date') border-red-500 @enderror"
                                           min="{{ now()->toDateString() }}"
                                           max="{{ now()->addYears(5)->toDateString() }}">
                                    @error('calendar.'.$index.'.end_date')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ __('Event end date') }}
                                    </p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium mb-1 text-gray-600">{{ __('Start Time') }}:</label>
                                    <input type="time"
                                           wire:model.lazy="calendar.{{ $index }}.start_time"
                                           class="w-full border rounded-md p-2 focus:outline-none focus:ring focus:border-blue-300 @error('calendar.'.$index.'.start_time') border-red-500 @enderror">
                                    @error('calendar.'.$index.'.start_time')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ __('Event start time') }}
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1 text-gray-600">{{ __('End Time') }}:</label>
                                    <input type="time"
                                           wire:model.lazy="calendar.{{ $index }}.end_time"
                                           class="w-full border rounded-md p-2 focus:outline-none focus:ring focus:border-blue-300 @error('calendar.'.$index.'.end_time') border-red-500 @enderror">
                                    @error('calendar.'.$index.'.end_time')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ __('Event end time') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="ri-calendar-line text-4xl mb-2"></i>
                        <p>{{ __('No event dates added yet') }}</p>
                        <p class="text-sm">{{ __('Click the button below to add your first event date') }}</p>
                    </div>
                @endif

                <div class="flex justify-center">
                    <button type="button"
                            wire:click="addEvent"
                            class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition flex items-center gap-2 shadow-md hover:shadow-lg">
                        <i class="ri-add-line text-lg"></i>
                        {{ __('Add Event Date') }}
                    </button>
                </div>
            </div>
        @endif
    </div>
</form>

<script>
    // معالج أخطاء Livewire
    document.addEventListener('livewire:init', () => {
        Livewire.on('snapshot-missing', (event) => {
            console.warn('Livewire snapshot missing, reloading component...');
            // إعادة تحميل الصفحة بلطف
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        });
    });

    // معالج أخطاء عام
    window.addEventListener('error', function(e) {
        if (e.message && e.message.includes('Snapshot missing')) {
            console.warn('Snapshot missing error detected, reloading...');
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        }
    });

    // معالج أخطاء Livewire
    document.addEventListener('livewire:error', function(event) {
        console.error('Livewire Error:', event.detail);

        if (event.detail.message && event.detail.message.includes('Snapshot missing')) {
            Swal.fire({
                title: '{{ __("Connection Lost") }}',
                text: '{{ __("The page will be refreshed to restore connection") }}',
                icon: 'warning',
                timer: 3000,
                showConfirmButton: false
            }).then(() => {
                window.location.reload();
            });
        }
    });
</script>
