<?php

namespace App\Livewire\Templates;

use Livewire\Component;
use App\Models\User;
use App\Models\Offering;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TemplateRouter extends Component
{
    public $merchant;
    public $offers_collection;
    public $selectedOffer;
    
    public $step = 0;
    public $times;
    public $selectedTime;

    public $calendarDate;
    public $selectedDate;
    public $selectedTime;

    public function previousMonth()
    {
        $this->calendarDate = Carbon::parse($this->calendarDate)->subMonth()->toDateString();
    }

    public function nextMonth()
    {
        $this->calendarDate = Carbon::parse($this->calendarDate)->addMonth()->toDateString();
    }

    public function selectDate($date)
    {
        $date = Carbon::parse($date)->startOfDay();

        if ($this->selectedOffer->type == 'services') {
            $maxDate = isset($this->times['max_reservation_date']) 
                ? Carbon::parse($this->times['max_reservation_date'])->startOfDay() 
                : null;

            $today = now()->startOfDay();

            if ($date->lt($today) || ($maxDate && $date->gt($maxDate))) {
                dd('التاريخ خارج النطاق المسموح.');
                return;
            }

            $dayName = strtolower($date->format('l')); // مثل "tuesday"
            if (!array_key_exists($dayName, $this->times['data'])) {
                dd('هذا اليوم غير متاح في الجدول الزمني.');
                return;
            }

            $this->selectedDate = $date->toDateString();
            return;
        }

        if ($this->selectedOffer->type == 'events') {
            $start = Carbon::parse($this->times['data'][0]["start_date"])->startOfDay();
            $end = Carbon::parse($this->times['data'][0]["end_date"])->startOfDay();

            if ($date->lt($start) || $date->gt($end)) {
                dd('التاريخ خارج النطاق المحدد للفعالية.');
                return;
            }

            $this->selectedDate = $date->toDateString();
        }
    }



    public function mount($merchant, $offers_collection = null)
    {
        //dd(fetch_time(33));
        $this->calendarDate = now()->toDateString();

        $this->offers_collection = Offering::where('user_id', $this->merchant->id)->where('status', 'active')->get();
        
        //dd($this->offers_collection, $this->merchant);
    }
    public function selectOffer($value)
    {
        $this->selectedOffer = Offering::find($value);
    }
    public function stepNext(){
        $this->step++;
        $this->Get_time();
        //logger('Current step: ' . $this->step);
    }
    public function resetForm()
    {
        $this->selectedOffer = null;
        $this->step = 0;
    }
    public function stepBack()
    {
        if ($this->step > 0) {
            $this->step--;
            $this->Get_time();
        }
    }

    public function Get_time(){
        if ($this->step === 1){
            $this->times = fetch_time($this->selectedOffer->id);
        }
        //dd($offer_time);
    }

    public function render()
    {
        //dd($this->merchant);


        return view('livewire.templates.template1.index');
    }
}
