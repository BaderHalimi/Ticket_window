<?php

namespace App\Livewire\Tepmlates\Template1\Item;

use Carbon\Carbon;
use Livewire\Component;

class View extends Component
{
    public $offer;
    public $availableDays = [2, 4, 10, 15];
    public $currentMonth;
    public $currentYear;
    public $selectedDate = null;
    public $selectedTime = null;
    public $timeSlots = [];
    public $daysLimit = 3;

    public $count = 1;
    public $price = 0;


    public function mount($offer, $daysLimit = 10)
    {
        $this->offer = $offer;
        $this->calcPrice();
        $this->daysLimit = $daysLimit;
        $this->currentMonth = request()->get('month', now()->month);
        $this->currentYear = request()->get('year', now()->year);

        $this->availableDays = [];
        $start = now()->startOfDay();

        if ($this->daysLimit > 0) {
            for ($i = 0; $i < $this->daysLimit; $i++) {
                $this->availableDays[] = $start->copy()->addDays($i)->toDateString();
            }
        } else {
            // غير محدود: أضف تواريخ سنة كاملة للأمان مثلاً
            for ($i = 0; $i < 365; $i++) {
                $this->availableDays[] = $start->copy()->addDays($i)->toDateString();
            }
        }
    }

    public function nextMonth()
    {
        $next = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->currentMonth = $next->month;
        $this->currentYear = $next->year;
    }

    public function prevMonth()
    {
        $prev = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->subMonth();
        $this->currentMonth = $prev->month;
        $this->currentYear = $prev->year;
    }



    public function selectDate($day)
    {
        $selected = Carbon::create($this->currentYear, $this->currentMonth, $day)->toDateString();

        if (in_array($selected, $this->availableDays)) {
            $this->selectedDate = $selected;
            $this->generateTimeSlots();
        }
    }
    public function selectTime($time){
        if (in_array($time, $this->timeSlots)) {
            $this->selectedTime = $time;
        } else {
            $this->selectedTime = null;
        }
    }

    public function subNumber()
    {
        if ($this->count > 1) {
            $this->count -= 1;
        }
        $this->calcPrice();
    }
    public function addNumber()
    {
        // if($this->count >1) {
        $this->count += 1;
        // }
        $this->calcPrice();
    }

    public function calcPrice()
    {
        if ($this->offer && $this->offer->price) {
            $this->price = $this->offer->price * $this->count;
        } else {
            $this->price = 0;
        }
    }
    public function generateTimeSlots()
    {
        $this->timeSlots = [];

        $duration = $this->offer->features['booking_duration'] ?? null;
        $unit = $this->offer->features['booking_unit'] ?? null;

        if (!$this->selectedDate) {
            return;
        }

        if (!$duration || !$unit) {
            $start = Carbon::parse($this->offer->start_time);
            $end = Carbon::parse($this->offer->end_time);
            $interval = 60;
        } else {
            switch ($unit) {
                case 'hour':
                    $interval = $duration * 60;
                    break;
                case 'minute':
                    $interval = $duration;
                    break;
                case 'quarter':
                    $interval = $duration * 15;
                    break;
                case 'day':
                    $interval = $duration * 24 * 60;
                    break;
                default:
                    $interval = 60;
            }

            $targetDay = Carbon::parse($this->selectedDate)->format('l');
            $schedule = $this->offer->features['work_schedule'][strtolower($targetDay)] ?? null;

            if ($schedule && $schedule['enabled'] && $schedule['start'] && $schedule['end']) {
                $start = Carbon::parse($this->selectedDate . ' ' . $schedule['start']);
                $end = Carbon::parse($this->selectedDate . ' ' . $schedule['end']);
            } else {
                $start = Carbon::parse($this->selectedDate . ' ' . ($this->offer->start_time ? Carbon::parse($this->offer->start_time)->format('H:i') : '08:00'));
                $end = Carbon::parse($this->selectedDate . ' ' . ($this->offer->end_time ? Carbon::parse($this->offer->end_time)->transla('H:i') :  '20:00'));
            }
        }

        while ($start->lt($end)) {
            $this->timeSlots[] = $start->translatedFormat('h:i A');
            $start->addMinutes($interval);
        }
    }

    public function render()
    {
        $date = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1);
        $daysInMonth = $date->daysInMonth;
        $firstDayIndex = $date->dayOfWeek;

        return view('livewire.tepmlates.template1.item.view', [
            'date' => $date,
            'daysInMonth' => $daysInMonth,
            'firstDayIndex' => $firstDayIndex,
        ]);
    }
}
// return view('livewire.tepmlates.template1.item.view');
