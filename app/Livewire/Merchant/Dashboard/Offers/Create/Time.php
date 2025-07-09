<?php

namespace App\Livewire\Merchant\Dashboard\Offers\Create;
use Livewire\Component;
use App\Models\Offering;

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
    
    public function mount()
    {
        if ($this->offering->features) {
            $features = $this->offering->features;

            $this->enable_time = $features['enabled'] ?? false;

            if ($this->offering->type == 'services') {
                $this->day = collect($features['days'] ?? [])
                    ->mapWithKeys(fn ($data, $day) => [$day => true])
                    ->toArray();

                $this->from_time = collect($features['days'] ?? [])
                    ->mapWithKeys(fn ($data, $day) => [$day => $data['from'] ?? null])
                    ->toArray();

                $this->to_time = collect($features['days'] ?? [])
                    ->mapWithKeys(fn ($data, $day) => [$day => $data['to'] ?? null])
                    ->toArray();
            }

            if ($this->offering->type == 'events') {
                $this->calendar = $features['calendar'] ?? [];
            }
        } else {
            // قيم مبدئية
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
        $this->calendar[] = [
            'date' => '',
            'start_time' => '',
            'end_time' => '',
        ];
    }

    public function removeEvent($index)
    {
        unset($this->calendar[$index]);
        $this->calendar = array_values($this->calendar);
        $this->save();
    }

    public function save()
    {
        $features = ['enabled' => $this->enable_time];

        if ($this->offering->type == 'services') {
            $features['type'] = 'service';
            $features['days'] = [];

            if ($this->enable_time) {
                foreach ($this->day as $dayName => $enabled) {
                    if ($enabled) {
                        $features['days'][$dayName] = [
                            'from' => $this->from_time[$dayName] ?? null,
                            'to' => $this->to_time[$dayName] ?? null,
                        ];
                    }
                }
            }
        }

        if ($this->offering->type == 'events') {
            $features['type'] = 'event';
            $features['calendar'] = $this->calendar;
        }

        $this->offering->features = $features;
        $this->offering->save();

        session()->flash('success', 'تم حفظ الأوقات بنجاح!');
    }
    public function applyDefaultToAll()
    {
        if ($this->default_day['enabled']) {
            foreach (['saturday','sunday','monday','tuesday','wednesday','thursday','friday'] as $d) {
                $this->day[$d] = true;
                $this->from_time[$d] = $this->default_day['from'];
                $this->to_time[$d] = $this->default_day['to'];
            }
        }
        $this->save();

    }
    public function updated() {
        $this->save();
    }

    public function render()
    {

        return view('livewire.merchant.dashboard.offers.create.time');
    }
}
