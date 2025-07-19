<?php

namespace App\Livewire\Templates;

use Livewire\Component;
use App\Models\User;
use App\Models\Offering;
use App\Models\Merchant\Branch;
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

    public $price = 1000;
    public $quantity = 1;
    public $couponCode = '';
    public $finalPrice;
    public $discount = 0;
    public $stock = 10;
    public $branch;
    public $selectedBranch = null;
    public $branchDetails;

    public function updatedSelectedBranch($branchId)
    {
        $this->branchDetails = Branch::find($branchId);
    }
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
        //get_quantity(33);
        //dd(can_booking_now(33,1));
        //dd(get_coupons(33));
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
        $this->pricing();
        $this->Get_Branches();

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
            $this->pricing();

            $this->Get_Branches();

        }
    }
    public function increaseQuantity() {
        if ($this->quantity >= $this->stock) {
            return; 
        }
        $this->quantity++;
        $this->updatePricing();


    }

    public function decreaseQuantity() {
        if ($this->quantity > 1 && $this->quantity <= $this->stock) {
            $this->quantity--;
            $this->updatePricing();


        }
    }
    public function selectTime($time)
    {
        $this->selectedTime = $time;
    }
    public function applyCoupon() {
        $coupons = collect(get_coupons($this->selectedOffer->id));

        if ($coupons->isEmpty()) {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'لا توجد كوبونات متاحة لهذا العرض.',
            ]);
            return;
        }
        $coupon = $coupons->first(fn($item) => $item['code'] === $this->couponCode);

        //dd($coupon, $this->couponCode);
        if (!$coupon) {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'الكوبون غير صالح.',
            ]);
            return;
        }

        if (\Carbon\Carbon::parse($coupon['expires_at'])->isPast()) {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'الكوبون منتهي الصلاحية.',
            ]);
            return;
        }

        $this->couponCode = $coupon['code'];
        $this->discount = (float) $coupon['discount'];
        $this->updatePricing();
    }

    public function updatePricing(){
        $this->finalPrice = ($this->price * $this->quantity) * (1 - $this->discount / 100);
    }

    public function pricing(){
        if ($this->selectedOffer && $this->step === 4) {
            $this->price = $this->selectedOffer->price;
            $this->stock = get_quantity($this->selectedOffer->id,$this->selectedBranch);
            $this->finalPrice = $this->price * $this->quantity;

        }
    }

    public function Get_time(){
        if ($this->step === 2){
            $this->times = fetch_time($this->selectedOffer->id);
        }
        //dd($offer_time);
    }
    
    public function Get_Branches(){
        if ($this->step === 1){
            $this->branch = get_branches($this->selectedOffer->id);
            //dd($this->branch);
        }
        //dd($offer_time);
    }
    
    public function render()
    {
        //dd($this->merchant);
        if ($this->step == 4){
            $this->updatePricing();
        }

        return view('livewire.templates.template1.index');
    }
}
