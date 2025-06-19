<?php

namespace App\Livewire\Merchant\Dashboard\Offers\Create;

use Livewire\Component;
use App\Models\Offering;

class ResSettings extends Component
{
    public Offering $offering;

    public bool $enable_duration = false;
    public $booking_duration = 1;
    public $booking_unit = 'hour';

    public bool $enable_user_interval = false;
    public $user_interval_minutes = 0;

    public bool $enable_global_interval = false;
    public $global_interval_minutes = 0;

    public bool $enable_work_schedule = false;
    public array $work_schedule = [
        'saturday' => ['enabled' => false, 'start' => '', 'end' => ''],
        'sunday' => ['enabled' => false, 'start' => '', 'end' => ''],
        'monday' => ['enabled' => false, 'start' => '', 'end' => ''],
        'tuesday' => ['enabled' => false, 'start' => '', 'end' => ''],
        'wednesday' => ['enabled' => false, 'start' => '', 'end' => ''],
        'thursday' => ['enabled' => false, 'start' => '', 'end' => ''],
        'friday' => ['enabled' => false, 'start' => '', 'end' => ''],
    ];
    
    public bool $enable_closed_days = false;
    public $closed_days = '';

    public bool $enable_user_limit = false;
    public $user_limit = 1;

    public bool $enable_booking_deadline = false;
    public $booking_deadline_minutes = 30;

    public bool $enable_weekly_recurrence = false;
    public $weekly_recurrence_days = '';

    public bool $enable_client_time_selection = false;

    public function mount(Offering $offering)
    {
        $this->offering = $offering;

        $features = $offering->features ?? [];

        $this->fill(array_merge([
            'enable_duration' => false,
            'booking_duration' => 1,
            'booking_unit' => 'hour',
            'enable_user_interval' => false,
            'user_interval_minutes' => 0,
            'enable_global_interval' => false,
            'global_interval_minutes' => 0,
            'enable_work_schedule' => false,
            'work_schedule' => [
                'saturday' => ['enabled' => false, 'start' => '', 'end' => ''],
                'sunday' => ['enabled' => false, 'start' => '', 'end' => ''],
                'monday' => ['enabled' => false, 'start' => '', 'end' => ''],
                'tuesday' => ['enabled' => false, 'start' => '', 'end' => ''],
                'wednesday' => ['enabled' => false, 'start' => '', 'end' => ''],
                'thursday' => ['enabled' => false, 'start' => '', 'end' => ''],
                'friday' => ['enabled' => false, 'start' => '', 'end' => ''],
            ],

            'enable_closed_days' => false,
            'closed_days' => '',
            'enable_user_limit' => false,
            'user_limit' => 1,
            'enable_booking_deadline' => false,
            'booking_deadline_minutes' => 30,
            'enable_weekly_recurrence' => false,
            'weekly_recurrence_days' => '',
            'enable_client_time_selection' => false,
        ], $features));
    }

    public function saveTimeSettings()
    {
        $this->offering->update([
            'features' => [
                'enable_duration' => (bool) $this->enable_duration,
                'booking_duration' => (int) $this->booking_duration,
                'booking_unit' => $this->booking_unit,
                'enable_user_interval' => (bool) $this->enable_user_interval,
                'user_interval_minutes' => (int) $this->user_interval_minutes,
                'enable_global_interval' => (bool) $this->enable_global_interval,
                'global_interval_minutes' => (int) $this->global_interval_minutes,
                'enable_work_schedule' => (bool) $this->enable_work_schedule,
                'work_schedule_notes' => $this->work_schedule,
                'enable_closed_days' => (bool) $this->enable_closed_days,
                'closed_days' => $this->closed_days,
                'enable_user_limit' => (bool) $this->enable_user_limit,
                'user_limit' => (int) $this->user_limit,
                'enable_booking_deadline' => (bool) $this->enable_booking_deadline,
                'booking_deadline_minutes' => (int) $this->booking_deadline_minutes,
                'enable_weekly_recurrence' => (bool) $this->enable_weekly_recurrence,
                'weekly_recurrence_days' => $this->weekly_recurrence_days,
                'enable_client_time_selection' => (bool) $this->enable_client_time_selection,
            ]
        ]);
    }

    // public function updated($property)
    // {
    //     $this->saveTimeSettings();
    //     session()->flash('success', 'تم الحفظ تلقائيًا');
    // }


    public function render()
    {
        return view('livewire.merchant.dashboard.offers.create.res-settings');
    }
}
