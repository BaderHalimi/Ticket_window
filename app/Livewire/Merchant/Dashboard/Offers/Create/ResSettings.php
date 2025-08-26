<?php

namespace App\Livewire\Merchant\Dashboard\Offers\Create;

use Livewire\Component;
use App\Models\Offering;
use App\Models\Merchant\Branch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
class ResSettings extends Component
{
    public Offering $offering;

    public bool $enable_duration = false;
    public $booking_duration = 1;
    public $booking_unit = 'hour';

    //public bool $enable_work_schedule = false;
    // public array $work_schedule = [
    //     'saturday' => ['enabled' => false, 'start' => '', 'end' => ''],
    //     'sunday' => ['enabled' => false, 'start' => '', 'end' => ''],
    //     'monday' => ['enabled' => false, 'start' => '', 'end' => ''],
    //     'tuesday' => ['enabled' => false, 'start' => '', 'end' => ''],
    //     'wednesday' => ['enabled' => false, 'start' => '', 'end' => ''],
    //     'thursday' => ['enabled' => false, 'start' => '', 'end' => ''],
    //     'friday' => ['enabled' => false, 'start' => '', 'end' => ''],
    // ];

    public bool $enable_closed_days = false;
    public array $closed_days = [];
    public string $new_closed_day = '';

    public bool $enable_user_limit = false;
    public $user_limit = 1;

    public bool $enable_booking_deadline = false;
    public $booking_deadline_minutes = 30;

    public bool $enable_weekly_recurrence = false;
    public $weekly_recurrence_days = '';

    public bool $enable_max_users = false;
    public $max_user_time = 1;
    public $max_user_unit = 'hour';
    public $eventMaxQuantity = 0;

    public $type;
    
    //public $enable_selected_branches = false;
    public $branches;
    public array $selected_branches = [];
    public $finalID;

    /**
     * Conditional validation rules based on current state
     */
    protected function rules()
    {
        $rules = [];

        // Booking Duration Settings - Only for services
        if ($this->offering->type == "services") {
            $rules['booking_duration'] = [
                'required',
                'integer',
                'min:1',
                'max:1440',
                'regex:/^[0-9]+$/'
            ];
            $rules['booking_unit'] = [
                'required',
                'string',
                'in:hour,minute',
                'regex:/^[a-z]+$/'
            ];
        }

        // User Limits - Only when enabled
        if ($this->enable_user_limit) {
            $rules['user_limit'] = [
                'required',
                'integer',
                'min:1',
                'max:1000',
                'regex:/^[0-9]+$/'
            ];
        }

        // Max Users Settings - Only for services
        if ($this->offering->type == "services") {
            $rules['max_user_time'] = [
                'nullable',
                'integer',
                'min:1',
                'max:10000',
                'regex:/^[0-9]+$/'
            ];
            $rules['max_user_unit'] = [
                'nullable',
                'string',
                'in:minute,hour,day,week',
                'regex:/^[a-z]+$/'
            ];
        }

        // Event Settings - Only for events
        if ($this->offering->type == "events") {
            $rules['eventMaxQuantity'] = [
                'nullable',
                'integer',
                'min:1',
                'max:100000',
                'regex:/^[0-9]+$/'
            ];
        }

        // Booking Deadline - Only when enabled
        if ($this->enable_booking_deadline) {
            $rules['booking_deadline_minutes'] = [
                'required',
                'integer',
                'min:0',
                'max:10080',
                'regex:/^[0-9]+$/'
            ];
        }

        // Closed Days - Only when enabled and for restaurants
        if ($this->enable_closed_days && $this->type == 'restaurant') {
            $rules['new_closed_day'] = [
                'nullable',
                'date',
                'after_or_equal:today',
                'before:' . now()->addYears(2)->format('Y-m-d')
            ];
            $rules['closed_days'] = [
                'nullable',
                'array',
                'max:365'
            ];
            $rules['closed_days.*'] = [
                'date',
                'after_or_equal:today',
                'before:' . now()->addYears(2)->format('Y-m-d')
            ];
        }

        // Work Schedule - Only when enabled and for restaurants
        if (isset($this->enable_work_schedule) && $this->enable_work_schedule && $this->type == 'restaurant') {
            $rules['work_schedule'] = ['nullable', 'array'];
            $rules['work_schedule.*.enabled'] = ['boolean'];

            // Only validate times for enabled days
            if (is_array($this->work_schedule)) {
                foreach ($this->work_schedule as $day => $schedule) {
                    if (isset($schedule['enabled']) && $schedule['enabled']) {
                        $rules["work_schedule.{$day}.start"] = [
                            'nullable',
                            'date_format:H:i',
                            'regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/'
                        ];
                        $rules["work_schedule.{$day}.end"] = [
                            'nullable',
                            'date_format:H:i',
                            'regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/',
                            "after:work_schedule.{$day}.start"
                        ];
                    }
                }
            }
        }

        // Selected Branches - Only for services with place center
        if ($this->offering->type == "services" &&
            isset($this->offering->features["center"]) &&
            $this->offering->features["center"] == "place") {
            $rules['selected_branches'] = [
                'nullable',
                'array',
                'max:100'
            ];
            $rules['selected_branches.*'] = [
                'integer',
                'exists:branches,id',
                'regex:/^[0-9]+$/'
            ];
        }

        // Weekly Recurrence - Only when enabled (currently commented out)
        if (isset($this->enable_weekly_recurrence) && $this->enable_weekly_recurrence) {
            $rules['weekly_recurrence_days'] = [
                'nullable',
                'string',
                'max:255',
                'regex:/^[\p{L}\p{N}\s\-_.,]+$/u'
            ];
        }

        return $rules;
    }

    /**
     * Custom validation messages
     */
    protected function messages()
    {
        return [
            // Booking Duration
            'booking_duration.required' => __('Booking duration is required'),
            'booking_duration.integer' => __('Booking duration must be a number'),
            'booking_duration.min' => __('Booking duration must be at least 1'),
            'booking_duration.max' => __('Booking duration cannot exceed 1440 minutes'),
            'booking_duration.regex' => __('Booking duration contains invalid characters'),

            'booking_unit.required' => __('Time unit is required'),
            'booking_unit.in' => __('Invalid time unit selected'),
            'booking_unit.regex' => __('Time unit contains invalid characters'),

            // User Limits
            'user_limit.integer' => __('User limit must be a number'),
            'user_limit.min' => __('User limit must be at least 1'),
            'user_limit.max' => __('User limit cannot exceed 1000'),
            'user_limit.regex' => __('User limit contains invalid characters'),

            // Max Users
            'max_user_time.integer' => __('Maximum users must be a number'),
            'max_user_time.min' => __('Maximum users must be at least 1'),
            'max_user_time.max' => __('Maximum users cannot exceed 10000'),
            'max_user_time.regex' => __('Maximum users contains invalid characters'),

            'max_user_unit.in' => __('Invalid time unit selected'),
            'max_user_unit.regex' => __('Time unit contains invalid characters'),

            // Event Settings
            'eventMaxQuantity.integer' => __('Event capacity must be a number'),
            'eventMaxQuantity.min' => __('Event capacity must be at least 1'),
            'eventMaxQuantity.max' => __('Event capacity cannot exceed 100000'),
            'eventMaxQuantity.regex' => __('Event capacity contains invalid characters'),

            // Booking Deadline
            'booking_deadline_minutes.integer' => __('Booking deadline must be a number'),
            'booking_deadline_minutes.min' => __('Booking deadline cannot be negative'),
            'booking_deadline_minutes.max' => __('Booking deadline cannot exceed 1 week'),
            'booking_deadline_minutes.regex' => __('Booking deadline contains invalid characters'),

            // Closed Days
            'new_closed_day.date' => __('Please enter a valid date'),
            'new_closed_day.after_or_equal' => __('Closed day cannot be in the past'),
            'new_closed_day.before' => __('Closed day cannot be more than 2 years ahead'),

            'closed_days.array' => __('Invalid closed days format'),
            'closed_days.max' => __('Cannot have more than 365 closed days'),
            'closed_days.*.date' => __('Invalid closed day date'),
            'closed_days.*.after_or_equal' => __('Closed day cannot be in the past'),
            'closed_days.*.before' => __('Closed day cannot be more than 2 years ahead'),

            // Work Schedule
            'work_schedule.*.start.date_format' => __('Invalid start time format'),
            'work_schedule.*.start.regex' => __('Start time contains invalid characters'),
            'work_schedule.*.end.date_format' => __('Invalid end time format'),
            'work_schedule.*.end.regex' => __('End time contains invalid characters'),
            'work_schedule.*.end.after' => __('End time must be after start time'),

            // Selected Branches
            'selected_branches.array' => __('Invalid branches selection'),
            'selected_branches.max' => __('Cannot select more than 100 branches'),
            'selected_branches.*.integer' => __('Invalid branch ID'),
            'selected_branches.*.exists' => __('Selected branch does not exist'),
            'selected_branches.*.regex' => __('Branch ID contains invalid characters'),

            // Weekly Recurrence
            'weekly_recurrence_days.max' => __('Weekly recurrence days text is too long'),
            'weekly_recurrence_days.regex' => __('Weekly recurrence days contains invalid characters')
        ];
    }

    public function mount(Offering $offering , $finalID)
    {
        $this->offering = $offering;
        $this->finalID = $finalID;
        $features = $offering->features ?? [];
        $this->type = $offering->type;
        // ✅ تأكد أن closed_days عبارة عن array دائمًا حتى لو كانت string
        if (isset($features['closed_days']) && is_string($features['closed_days'])) {
            $features['closed_days'] = array_filter(array_map('trim', explode(',', $features['closed_days'])));
        }
        if (!isset($features['selected_branches']) || !is_array($features['selected_branches'])) {
            $features['selected_branches'] = [];
        }
        
        $this->branches = Branch::where('user_id', $this->finalID)->get();
        $this->fill(array_merge([
            'enable_duration' => false,
            'booking_duration' => 1,
            'booking_unit' => 'hour',

            // 'enable_work_schedule' => false,
            // 'work_schedule' => $this->work_schedule,

            'enable_closed_days' => false,
            'closed_days' => [],
            'new_closed_day' => '',

            'enable_user_limit' => false,
            'user_limit' => 1,

            'enable_max_users' => false,
            'max_user_time' => 1,
            'max_user_unit' => 'hour',

            'enable_booking_deadline' => false,
            'booking_deadline_minutes' => 30,

            'enable_weekly_recurrence' => false,
            'weekly_recurrence_days' => '',
            //'enable_selected_branches' => false,
            'selected_branches' => [],
            'eventMaxQuantity' => 0,

        ], $features));
    }

    public function addClosedDay()
    {
        // Validate the new closed day
        $this->validate([
            'new_closed_day' => [
                'required',
                'date',
                'after_or_equal:today',
                'before:' . now()->addYears(2)->format('Y-m-d')
            ]
        ], [
            'new_closed_day.required' => __('Please select a date'),
            'new_closed_day.date' => __('Please enter a valid date'),
            'new_closed_day.after_or_equal' => __('Closed day cannot be in the past'),
            'new_closed_day.before' => __('Closed day cannot be more than 2 years ahead')
        ]);

        // Check if date already exists
        if (in_array($this->new_closed_day, $this->closed_days)) {
            $this->addError('new_closed_day', __('This date is already in the closed days list'));
            return;
        }

        // Check maximum limit
        if (count($this->closed_days) >= 365) {
            $this->addError('new_closed_day', __('Cannot add more than 365 closed days'));
            return;
        }

        // Sanitize and add the date
        $sanitizedDate = sanitizeInput(trim($this->new_closed_day));
        $this->closed_days[] = $sanitizedDate;
        $this->new_closed_day = '';

        $this->saveTimeSettings();
    }

    public function removeClosedDay($index)
    {
        // Validate index to prevent array manipulation attacks
        if (!is_numeric($index) || $index < 0 || $index >= count($this->closed_days)) {
            $this->addError('closed_days', __('Invalid closed day index'));
            return;
        }

        // Sanitize index
        $index = (int) $index;

        // Remove the closed day
        unset($this->closed_days[$index]);
        $this->closed_days = array_values($this->closed_days);

        $this->saveTimeSettings();
    }

    public function saveTimeSettings()
    {
        // Validate only active/enabled inputs with XSS and SQL injection protection
        $this->validate();

        // Sanitize and process inputs based on their enabled state
        $features = $this->offering->features ?? [];

        // Booking Duration Settings - Only for services
        if ($this->offering->type == "services") {
            $features['enable_duration'] = $this->enable_duration;
            $features['booking_duration'] = (int) $this->booking_duration;
            $features['booking_unit'] = sanitizeInput($this->booking_unit);
        }

        // User Limits - Only when enabled
        if ($this->enable_user_limit) {
            $features['enable_user_limit'] = true;
            $features['user_limit'] = (int) $this->user_limit;
        } else {
            $features['enable_user_limit'] = false;
            $features['user_limit'] = null;
        }

        // Max Users Settings - Only for services
        if ($this->offering->type == "services") {
            $features['enable_max_users'] = $this->enable_max_users;
            $features['max_user_time'] = $this->max_user_time ? (int) $this->max_user_time : null;
            $features['max_user_unit'] = $this->max_user_unit ? sanitizeInput($this->max_user_unit) : null;
        }

        // Event Settings - Only for events
        if ($this->offering->type == "events") {
            $features['eventMaxQuantity'] = $this->eventMaxQuantity ? (int) $this->eventMaxQuantity : 0;
        }

        // Booking Deadline - Only when enabled
        if ($this->enable_booking_deadline) {
            $features['enable_booking_deadline'] = true;
            $features['booking_deadline_minutes'] = (int) $this->booking_deadline_minutes;
        } else {
            $features['enable_booking_deadline'] = false;
            $features['booking_deadline_minutes'] = null;
        }

        // Closed Days - Only when enabled and for restaurants
        if ($this->enable_closed_days && $this->type == 'restaurant') {
            $features['enable_closed_days'] = true;
            // Sanitize closed days array
            if (is_array($this->closed_days)) {
                $features['closed_days'] = array_map(fn($date) => sanitizeInput($date), $this->closed_days);
            } else {
                $features['closed_days'] = [];
            }
        } else {
            $features['enable_closed_days'] = false;
            $features['closed_days'] = [];
        }

        // Work Schedule - Only when enabled and for restaurants
        if (isset($this->enable_work_schedule) && $this->enable_work_schedule && $this->type == 'restaurant') {
            $features['enable_work_schedule'] = true;
            // Sanitize work schedule if exists
            if (is_array($this->work_schedule)) {
                $sanitizedSchedule = [];
                foreach ($this->work_schedule as $day => $schedule) {
                    $sanitizedSchedule[$day] = [
                        'enabled' => (bool) ($schedule['enabled'] ?? false),
                        'start' => isset($schedule['start']) ? sanitizeInput($schedule['start']) : '',
                        'end' => isset($schedule['end']) ? sanitizeInput($schedule['end']) : ''
                    ];
                }
                $features['work_schedule'] = $sanitizedSchedule;
            }
        } else {
            $features['enable_work_schedule'] = false;
            $features['work_schedule'] = [];
        }

        // Selected Branches - Only for services with place center
        if ($this->offering->type == "services" &&
            isset($this->offering->features["center"]) &&
            $this->offering->features["center"] == "place") {

            // Validate selected branches belong to current user
            if (!empty($this->selected_branches)) {
                $validBranches = Branch::where('user_id', $this->finalID)
                    ->whereIn('id', $this->selected_branches)
                    ->pluck('id')
                    ->toArray();

                $features['selected_branches'] = $validBranches;
            } else {
                $features['selected_branches'] = [];
            }
        }

        // Weekly Recurrence - Only when enabled (currently commented out)
        if (isset($this->enable_weekly_recurrence) && $this->enable_weekly_recurrence) {
            $features['enable_weekly_recurrence'] = true;
            $features['weekly_recurrence_days'] = sanitizeInput($this->weekly_recurrence_days);
        } else {
            $features['enable_weekly_recurrence'] = false;
            $features['weekly_recurrence_days'] = '';
        }

        $features['enable_duration'] = $this->enable_duration;
        $features['booking_duration'] = (int) $this->booking_duration;
        $features['booking_unit'] = $this->booking_unit;

        // $features['enable_work_schedule'] = $this->enable_work_schedule;
        // $features['work_schedule'] = $this->work_schedule;

        $features['enable_closed_days'] = $this->enable_closed_days;
        $features['closed_days'] = $this->closed_days;

        $features['enable_user_limit'] = $this->enable_user_limit;
        $features['user_limit'] = (int) $this->user_limit;

        $features['enable_max_users'] = $this->enable_max_users;
        $features['max_user_time'] = (int) $this->max_user_time;
        $features['max_user_unit'] = $this->max_user_unit;

        $features['enable_booking_deadline'] = $this->enable_booking_deadline;
        $features['booking_deadline_minutes'] = (int) $this->booking_deadline_minutes;

        $features['enable_weekly_recurrence'] = $this->enable_weekly_recurrence;
        $features['weekly_recurrence_days'] = $this->weekly_recurrence_days;
        $features['eventMaxQuantity'] = (int) $this->eventMaxQuantity;
        //$features['enable_selected_branches'] = $this->enable_selected_branches;
        $features['selected_branches'] = collect($this->branches)
        ->whereIn('id', $this->selected_branches)
        ->pluck('id')
        ->values()
        ->toArray();
    
        $this->offering->update([
            'features' => $features,
            'status' => 'inactive'
        ]);
        $this->dispatch('ServiceUpdated');
    }

    public function render()
    {
        return view('livewire.merchant.dashboard.offers.create.res-settings');
    }
}
