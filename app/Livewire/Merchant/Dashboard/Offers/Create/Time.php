<?php

namespace App\Livewire\Merchant\Dashboard\Offers\Create;

use Livewire\Component;
use App\Models\Offering;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class Time extends Component
{
    public Offering $offering;

    public bool $enable_time = true;
    public $day = [];
    public $from_time = [];
    public $to_time = [];
    public $calendar = [];
    public $default_day = [
        'enabled' => false,
        'from' => null,
        'to' => null,
    ];
    public $max_reservation_date;
    public $active_max_reservation_date;

    /**
     * Conditional validation rules based on current state
     */
    protected function rules()
    {
        $rules = [];

        // Services validation
        if ($this->offering->type == 'services') {
            // Default day validation - only when enabled
            if (isset($this->default_day['enabled']) && $this->default_day['enabled']) {
                $rules['default_day.from'] = [
                    'required',
                    'date_format:H:i',
                    'regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/'
                ];
                $rules['default_day.to'] = [
                    'required',
                    'date_format:H:i',
                    'regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/',
                    'after:default_day.from'
                ];
            }

            // Individual days validation - only for enabled days
            foreach (['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $dayName) {
                if (isset($this->day[$dayName]) && $this->day[$dayName]) {
                    $rules["from_time.{$dayName}"] = [
                        'required',
                        'date_format:H:i',
                        'regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/'
                    ];
                    $rules["to_time.{$dayName}"] = [
                        'required',
                        'date_format:H:i',
                        'regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/',
                        "after:from_time.{$dayName}"
                    ];
                }
            }

            // Max reservation date - only when enabled
            if ($this->active_max_reservation_date) {
                $rules['max_reservation_date'] = [
                    'required',
                    'date',
                    'after_or_equal:today',
                    'before:' . now()->addYears(5)->format('Y-m-d')
                ];
            }
        }

        // Events validation
        if ($this->offering->type == 'events') {
            $rules['calendar'] = [
                'nullable',
                'array',
                'max:100'
            ];

            // Validate each calendar event - only validate filled events
            if (is_array($this->calendar)) {
                foreach ($this->calendar as $index => $event) {
                    // Only validate if event has some data filled
                    $hasData = !empty($event['start_date']) || !empty($event['end_date']) ||
                        !empty($event['start_time']) || !empty($event['end_time']);

                    if ($hasData) {
                        $rules["calendar.{$index}.start_date"] = [
                            'required',
                            'date',
                            'after_or_equal:today',
                            'before:' . now()->addYears(5)->format('Y-m-d')
                        ];
                        $rules["calendar.{$index}.end_date"] = [
                            'required',
                            'date',
                            'after_or_equal:today',
                            'after_or_equal:calendar.' . $index . '.start_date',
                            'before:' . now()->addYears(5)->format('Y-m-d')
                        ];
                        $rules["calendar.{$index}.start_time"] = [
                            'required',
                            'date_format:H:i',
                            'regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/'
                        ];
                        $rules["calendar.{$index}.end_time"] = [
                            'required',
                            'date_format:H:i',
                            'regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/'
                        ];

                        // Always validate end time is after start time for events
                        // If same date, end time must be after start time
                        if (
                            isset($event['start_date']) && isset($event['end_date']) &&
                            $event['start_date'] === $event['end_date']
                        ) {
                            $rules["calendar.{$index}.end_time"][] = "after:calendar.{$index}.start_time";
                        }
                    }
                }
            }
        }

        return $rules;
    }

    /**
     * Custom validation messages
     */
    protected function messages()
    {
        return [
            // Default day messages
            'default_day.from.required' => __('Default start time is required'),
            'default_day.from.date_format' => __('Invalid start time format'),
            'default_day.from.regex' => __('Start time contains invalid characters'),
            'default_day.to.required' => __('Default end time is required'),
            'default_day.to.date_format' => __('Invalid end time format'),
            'default_day.to.regex' => __('End time contains invalid characters'),
            'default_day.to.after' => __('End time must be after start time'),

            // Individual days messages
            'from_time.*.required' => __('Start time is required for enabled days'),
            'from_time.*.date_format' => __('Invalid start time format'),
            'from_time.*.regex' => __('Start time contains invalid characters'),
            'to_time.*.required' => __('End time is required for enabled days'),
            'to_time.*.date_format' => __('Invalid end time format'),
            'to_time.*.regex' => __('End time contains invalid characters'),
            'to_time.*.after' => __('End time must be after start time'),

            // Max reservation date messages
            'max_reservation_date.required' => __('Maximum reservation date is required'),
            'max_reservation_date.date' => __('Please enter a valid date'),
            'max_reservation_date.after_or_equal' => __('Maximum reservation date cannot be in the past'),
            'max_reservation_date.before' => __('Maximum reservation date cannot be more than 5 years ahead'),

            // Calendar events messages
            'calendar.required' => __('At least one event date is required'),
            'calendar.array' => __('Invalid calendar format'),
            'calendar.min' => __('At least one event date is required'),
            'calendar.max' => __('Cannot have more than 100 event dates'),

            'calendar.*.start_date.required' => __('Event start date is required'),
            'calendar.*.start_date.date' => __('Please enter a valid start date'),
            'calendar.*.start_date.after_or_equal' => __('Event start date cannot be in the past'),
            'calendar.*.start_date.before' => __('Event start date cannot be more than 5 years ahead'),

            'calendar.*.end_date.required' => __('Event end date is required'),
            'calendar.*.end_date.date' => __('Please enter a valid end date'),
            'calendar.*.end_date.after_or_equal' => __('Event end date cannot be before start date'),
            'calendar.*.end_date.before' => __('Event end date cannot be more than 5 years ahead'),

            'calendar.*.start_time.required' => __('Event start time is required'),
            'calendar.*.start_time.date_format' => __('Invalid start time format'),
            'calendar.*.start_time.regex' => __('Start time contains invalid characters'),

            'calendar.*.end_time.required' => __('Event end time is required'),
            'calendar.*.end_time.date_format' => __('Invalid end time format'),
            'calendar.*.end_time.regex' => __('End time contains invalid characters'),
            'calendar.*.end_time.after' => __('End time must be after start time')
        ];
    }

    public function mount()
    {
        try {
            if ($this->offering->features) {
                $features = $this->offering->features;

                $this->enable_time = $features['enabled'] ?? true;

                if ($this->offering->type == 'services') {
                    $this->active_max_reservation_date = $features['active_max_reservation_date'] ?? null;
                    $this->max_reservation_date = $features['max_reservation_date'] ?? null;
                    $this->day = [
                        'saturday' => false,
                        'sunday' => false,
                        'monday' => false,
                        'tuesday' => false,
                        'wednesday' => false,
                        'thursday' => false,
                        'friday' => false,
                    ];

                    $this->from_time = [];
                    $this->to_time = [];

                    if (isset($features['days'])) {
                        foreach ($features['days'] as $dayName => $dayData) {
                            if (array_key_exists($dayName, $this->day)) {
                                $this->day[$dayName] = true;
                                $this->from_time[$dayName] = $dayData['from'] ?? '';
                                $this->to_time[$dayName] = $dayData['to'] ?? '';
                            }
                        }
                    }
                }

                if ($this->offering->type == 'events') {
                    $this->calendar = $features['calendar'] ?? [];
                }
            } else {
                // القيم الافتراضية
                $this->day = [
                    'saturday' => false,
                    'sunday' => false,
                    'monday' => false,
                    'tuesday' => false,
                    'wednesday' => false,
                    'thursday' => false,
                    'friday' => false,
                ];
            }
        } catch (\Exception $e) {
            // Log the error and set default values
            Log::error('Time component mount error: ' . $e->getMessage());

            $this->enable_time = true;
            $this->active_max_reservation_date = false;
            $this->max_reservation_date = null;
            $this->calendar = [];

            // Initialize default day structure
            $this->day = [
                'saturday' => false,
                'sunday' => false,
                'monday' => false,
                'tuesday' => false,
                'wednesday' => false,
                'thursday' => false,
                'friday' => false,
            ];
        }
    }

    public function addEvent()
    {
        // Check maximum limit
        if (count($this->calendar) >= 100) {
            $this->addError('calendar', __('Cannot add more than 100 event dates'));
            return;
        }

        $this->calendar[] = [
            'start_date' => '',
            'end_date' => '',
            'start_time' => '',
            'end_time' => '',
        ];

        // Save without validation to keep empty events
        $this->save(false);
    }

    public function removeEvent($index)
    {
        // Validate index to prevent array manipulation attacks
        if (!is_numeric($index) || $index < 0 || $index >= count($this->calendar)) {
            $this->addError('calendar', __('Invalid event index'));
            return;
        }

        // Sanitize index
        $index = (int) $index;

        unset($this->calendar[$index]);
        $this->calendar = array_values($this->calendar);
        $this->save(false);
    }
    public function save($withValidate = true)
    {
        // Validate inputs with XSS and SQL injection protection
        if ($withValidate)
            $this->validate();

        $features = $this->offering->features ?? [];

        $features['enabled'] = $this->enable_time;
        $features['active_max_reservation_date'] = $this->active_max_reservation_date ?? null;

        // Max reservation date handling
        if ($this->active_max_reservation_date) {
            $features['max_reservation_date'] = sanitizeInput($this->max_reservation_date);
        } else {
            $features['max_reservation_date'] = Carbon::parse("3000-12-31");
        }

        // Services handling
        if ($this->offering->type == 'services') {
            $features['type'] = 'service';
            $features['days'] = [];

            foreach ($this->day as $dayName => $enabled) {
                if ($enabled && isset($this->from_time[$dayName]) && isset($this->to_time[$dayName])) {
                    $features['days'][$dayName] = [
                        'from' => sanitizeInput($this->from_time[$dayName]),
                        'to' => sanitizeInput($this->to_time[$dayName]),
                    ];
                }
            }
        }

        // Events calendar handling - keep all events, even empty ones for editing
        $sanitizedCalendar = [];
        if (is_array($this->calendar)) {
            foreach ($this->calendar as $event) {
                // Keep all events, including empty ones for user to fill
                $sanitizedCalendar[] = [
                    'start_date' => isset($event['start_date']) ? sanitizeInput($event['start_date']) : '',
                    'end_date' => isset($event['end_date']) ? sanitizeInput($event['end_date']) : '',
                    'start_time' => isset($event['start_time']) ? sanitizeInput($event['start_time']) : '',
                    'end_time' => isset($event['end_time']) ? sanitizeInput($event['end_time']) : ''
                ];
            }
        }
        $features['calendar'] = $sanitizedCalendar;

        $this->offering->features = $features;
        $this->offering->save();

        $this->dispatch('saved');
    }

    /**
     * Validate for final save - check that events have complete data
     */
    public function validateForFinalSave()
    {
        // For events, ensure at least one complete event exists
        if ($this->offering->type == 'events') {
            $completeEvents = 0;

            if (is_array($this->calendar)) {
                foreach ($this->calendar as $event) {
                    if (
                        !empty($event['start_date']) && !empty($event['end_date']) &&
                        !empty($event['start_time']) && !empty($event['end_time'])
                    ) {
                        $completeEvents++;
                    }
                }
            }

            if ($completeEvents === 0) {
                $this->addError('calendar', __('At least one complete event date is required'));
                return false;
            }
        }

        // For services, ensure at least one day is enabled
        if ($this->offering->type == 'services') {
            $enabledDays = 0;

            foreach ($this->day as $dayName => $enabled) {
                if ($enabled && !empty($this->from_time[$dayName]) && !empty($this->to_time[$dayName])) {
                    $enabledDays++;
                }
            }

            if ($enabledDays === 0) {
                $this->addError('day', __('At least one day with complete time settings is required'));
                return false;
            }
        }

        return true;
    }

    /**
     * Custom validation for time logic
     */
    public function updated($propertyName)
    {
        // Validate time fields when they are updated
        if (str_contains($propertyName, 'calendar.') && (str_contains($propertyName, '.end_time') || str_contains($propertyName, '.start_time'))) {
            $this->validateTimeLogic($propertyName);
        }

        if (str_contains($propertyName, 'calendar.') && str_contains($propertyName, '.end_date')) {
            $this->validateDateLogic($propertyName);
        }

        if (str_contains($propertyName, 'calendar.') && str_contains($propertyName, '.start_date')) {
            $this->validateStartDateLogic($propertyName);
        }

        if (str_contains($propertyName, 'to_time.') || str_contains($propertyName, 'from_time.')) {
            $this->validateDayTimeLogic($propertyName);
        }

        if ($propertyName === 'default_day.to') {
            $this->validateDefaultTimeLogic();
        }

        // Save changes (without validation to avoid removing empty events)
        $this->save(false);
    }

    /**
     * Validate start date logic
     */
    private function validateStartDateLogic($propertyName)
    {
        // Extract index from property name like "calendar.0.start_date"
        preg_match('/calendar\.(\d+)\.start_date/', $propertyName, $matches);
        if (!isset($matches[1])) return;

        $index = $matches[1];
        $event = $this->calendar[$index] ?? null;

        if (!$event) return;

        $startDate = $event['start_date'] ?? '';
        $startTime = $event['start_time'] ?? '';

        // If start date is today and start time is filled, validate start time is not in the past
        if ($startDate && $startTime && $startDate === now()->toDateString()) {
            $currentTime = now()->format('H:i');
            if (strtotime($startTime) < strtotime($currentTime)) {
                $this->addError("calendar.{$index}.start_time", __('Start time cannot be in the past'));
            } else {
                $this->resetErrorBag("calendar.{$index}.start_time");
            }
        }
    }

    /**
     * Validate event date logic
     */
    private function validateDateLogic($propertyName)
    {
        // Extract index from property name like "calendar.0.end_date"
        preg_match('/calendar\.(\d+)\.end_date/', $propertyName, $matches);
        if (!isset($matches[1])) return;

        $index = $matches[1];
        $event = $this->calendar[$index] ?? null;

        if (!$event) return;

        $startDate = $event['start_date'] ?? '';
        $endDate = $event['end_date'] ?? '';

        // If both dates are filled, validate end date is after or equal start date
        if ($startDate && $endDate) {
            if (strtotime($endDate) < strtotime($startDate)) {
                $this->addError("calendar.{$index}.end_date", __('End date must be after or equal to start date'));
            } else {
                $this->resetErrorBag("calendar.{$index}.end_date");
            }
        }
    }

    /**
     * Validate event time logic
     */
    private function validateTimeLogic($propertyName)
    {
        // Extract index from property name like "calendar.0.end_time" or "calendar.0.start_time"
        preg_match('/calendar\.(\d+)\.(start_time|end_time)/', $propertyName, $matches);
        if (!isset($matches[1])) return;

        $index = $matches[1];
        $timeField = $matches[2]; // 'start_time' or 'end_time'
        $event = $this->calendar[$index] ?? null;

        if (!$event) return;

        $startDate = $event['start_date'] ?? '';
        $endDate = $event['end_date'] ?? '';
        $startTime = $event['start_time'] ?? '';
        $endTime = $event['end_time'] ?? '';

        // Clear previous errors for the field being validated
        $this->resetErrorBag("calendar.{$index}.{$timeField}");

        // If both times are filled, validate end time is after start time
        if ($startTime && $endTime) {
            if (strtotime($endTime) <= strtotime($startTime)) {
                $this->addError("calendar.{$index}.end_time", __('End time must be after start time'));
                return;
            } else {
                // Clear end_time error if validation passes
                $this->resetErrorBag("calendar.{$index}.end_time");
            }
        }

        // Validate start time is not in the past (if start date is today)
        if ($timeField === 'start_time' && $startDate && $startTime && $startDate === now()->toDateString()) {
            $currentTime = now()->format('H:i');
            if (strtotime($startTime) < strtotime($currentTime)) {
                $this->addError("calendar.{$index}.start_time", __('Start time cannot be in the past'));
                return;
            }
        }

        // Validate end time is not in the past (if end date is today)
        if ($timeField === 'end_time' && $endDate && $endTime && $endDate === now()->toDateString()) {
            $currentTime = now()->format('H:i');
            if (strtotime($endTime) < strtotime($currentTime)) {
                $this->addError("calendar.{$index}.end_time", __('End time cannot be in the past'));
                return;
            }
        }
    }

    /**
     * Validate day time logic
     */
    private function validateDayTimeLogic($propertyName)
    {
        // Extract day name from property like "to_time.saturday" or "from_time.saturday"
        preg_match('/(to_time|from_time)\.(\w+)/', $propertyName, $matches);
        if (!isset($matches[2])) return;

        $timeField = $matches[1]; // 'to_time' or 'from_time'
        $dayName = $matches[2];
        $fromTime = $this->from_time[$dayName] ?? '';
        $toTime = $this->to_time[$dayName] ?? '';

        // Clear previous errors for the field being validated
        $this->resetErrorBag("{$timeField}.{$dayName}");

        // If both times are filled, validate end time is after start time
        if ($fromTime && $toTime) {
            if (strtotime($toTime) <= strtotime($fromTime)) {
                $this->addError("to_time.{$dayName}", __('End time must be after start time'));
                return;
            }
        }

        // If this is today and the day is enabled, validate times are not in the past
        $today = strtolower(now()->format('l')); // Get current day name (e.g., 'saturday')

        if ($dayName === $today && ($this->day[$dayName] ?? false)) {
            $currentTime = now()->format('H:i');

            // Validate start time is not in the past
            if ($fromTime && strtotime($fromTime) < strtotime($currentTime)) {
                $this->addError("from_time.{$dayName}", __('Start time cannot be in the past'));
            } else {
                $this->resetErrorBag("from_time.{$dayName}");
            }

            // Validate end time is not in the past
            if ($toTime && strtotime($toTime) < strtotime($currentTime)) {
                $this->addError("to_time.{$dayName}", __('End time cannot be in the past'));
            }
        }
    }

    /**
     * Validate default time logic
     */
    private function validateDefaultTimeLogic()
    {
        $fromTime = $this->default_day['from'] ?? '';
        $toTime = $this->default_day['to'] ?? '';

        // If both times are filled, validate end time is after start time
        if ($fromTime && $toTime) {
            if (strtotime($toTime) <= strtotime($fromTime)) {
                $this->addError('default_day.to', __('End time must be after start time'));
            } else {
                $this->resetErrorBag('default_day.to');
            }
        }
    }

    public function applyDefaultToAll()
    {
        // Validate default day settings first
        if ($this->default_day['enabled']) {
            $this->validate([
                'default_day.from' => [
                    'required',
                    'date_format:H:i',
                    'regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/'
                ],
                'default_day.to' => [
                    'required',
                    'date_format:H:i',
                    'regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/',
                    'after:default_day.from'
                ]
            ]);

            // Apply sanitized values to all days
            foreach (['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $d) {
                $this->day[$d] = true;
                $this->from_time[$d] = sanitizeInput($this->default_day['from']);
                $this->to_time[$d] = sanitizeInput($this->default_day['to']);
            }
        }

        $this->save();
    }


    public function render()
    {

        return view('livewire.merchant.dashboard.offers.create.time');
    }
}
