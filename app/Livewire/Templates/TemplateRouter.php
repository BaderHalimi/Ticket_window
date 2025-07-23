<?php

namespace App\Livewire\Templates;

use Livewire\Component;
use App\Models\User;
use App\Models\Offering;
use App\Models\Merchant\Branch;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Cart;
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
    public $coupon;
    public $finalPrice;
    public $discount = 0;
    public $stock = 10;
    public $branch;
    public $selectedBranch = null;
    public $branchDetails;

    public $Qa = [];
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
        //dd(translate("هل تود الحصول على عرض اضافي","auto" ,$target = "en"));
        //dd($this->offers_collection, $this->merchant);
    }
    public function loadQ(){
        if ($this->step==5 && empty($this->Qa)){

            $data = $this->selectedOffer->additional_data;
            $this->Qa = collect($data['questions'] ?? [])->map(function ($q) {
            return [
                'question' => $q['question'],
                'answer' => '',
            ];
            })->toArray();


        }
    }
    public function selectOffer($value)
    {
        if (isset($this->selectedOffer) && isset($this->selectedOffer->id) && $value == $this->selectedOffer->id) {
            return;
        }   

        $this->resetForm();
        $this->step = 0;
        $this->selectedOffer = Offering::find($value);

    }
    public function stepNext(){
        $this->step++;
        $this->Get_time();
        $this->pricing();
        $this->is_ready();
        $this->Get_Branches();
        $this->loadQ();
        if ($this->step == 7) {
            $this->save();
        }

        //logger('Current step: ' . $this->step);
    }
    public function resetForm()
    {

        $this->selectedOffer = null;
        $this->step = 0;
        $this->selectedTime = null;
        $this->selectedDate = null;
        $this->price = null;
        $this->quantity = 1;
        $this->couponCode = '';
        $this->coupon = null;
        $this->finalPrice = null;
        $this->discount = 0;
        $this->stock = null;
        $this->branch = null;
        $this->selectedBranch = null;
        $this->branchDetails = null;

        $this->times = null;
        $this->calendarDate = now()->toDateString();
    
    }
    public function stepBack()
    {
        if ($this->step > 0) {
            $this->step--;
            $this->Get_time();
            $this->pricing();
            $this->Get_Branches();
            $this->loadQ();

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
            $this->discount = 0;
            $this->couponCode = '';

            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'الكوبون غير صالح.',
            ]);
            return;
        }

        if (\Carbon\Carbon::parse($coupon['expires_at'])->isPast()) {
            $this->discount = 0;
            $this->couponCode = '';
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'الكوبون منتهي الصلاحية.',
            ]);
            return;
        }
        $this->coupon = $coupon;
        $this->couponCode = $coupon['code'];
        $this->discount = (float) $coupon['discount'];
    }
    public function UpdateCopoun(){
        $this->applyCoupon();
        $this->updatePricing();

    }

    public function updatePricing(){
        $this->applyCoupon();
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
    public function ready() {
    if (
        $this->selectedOffer &&
        $this->selectedTime &&
        $this->selectedDate &&
        $this->quantity &&
        $this->finalPrice
    ) {
        if ($this->selectedOffer->type == 'services') {
            if (get_branches($this->selectedOffer->id)->isNotEmpty()){
                if (!$this->selectedBranch) {
                    $this->dispatch('alert', [
                        'type' => 'error',
                        'message' => 'يرجى اختيار فرع قبل المتابعة.',
                    ]);
                    return false;
                }

                if (!can_booking_now($this->selectedOffer->id, $this->selectedBranch)) {
                    $this->dispatch('alert', [
                        'type' => 'error',
                        'message' => 'لا يمكن الحجز الآن لهذا العرض.',
                    ]);
                    return false;
                }

            
            }else {
                if (!can_booking_now($this->selectedOffer->id)) {
                    $this->dispatch('alert', [
                        'type' => 'error',
                        'message' => 'لا يمكن الحجز الآن لهذا العرض.',
                    ]);
                    return false;
                }
            }

        }

        if ($this->selectedOffer->type == 'events') {
            if (!can_booking_now($this->selectedOffer->id)) {
                $this->dispatch('alert', [
                    'type' => 'error',
                    'message' => 'لا يمكن الحجز الآن لهذا العرض.',
                ]);
                return false;
            }
        }

        return true;
    }

    return false; // مهم جداً
}

    public function is_ready(){
        if ($this->step == 6){
            return $this->ready();
        } else {
            return false;
        }
    }
    public function save(){
        if($this->ready() && $this->step == 7) {
            $user = Auth::user();
            $branchId = $this->selectedBranch ? $this->selectedBranch : null;

            // $reservation = $user->reservations()->create([
            //     'offering_id' => $this->selectedOffer->id,
            //     'branch_id' => $branchId,
            //     'quantity' => $this->quantity,
            //     'price' => $this->finalPrice,
            //     'discount' => $this->discount,
            //     'additional_data' => json_encode([
            //         'selected_date' => $this->selectedDate,
            //         'selected_time' => $this->selectedTime,
            //         'coupon_code' => $this->couponCode,
            //         'branch' => $this->selectedBranch,
            //     ])
        
            // ]);
            //dd(Auth::guard('merchant')->id());
            $cart = Cart::create([
                'item_id' => $this->selectedOffer->id,
                'item_type' => $this->selectedOffer->type,
                'user_id' => Auth::guard('merchant')->id(),
                'quantity' => $this->quantity,
                'price' => $this->finalPrice,
                'discount' => $this->discount,
                'additional_data' => [
                    'selected_date' => $this->selectedDate,
                    'selected_time' => $this->selectedTime,
                    'coupon_code' => $this->couponCode,
                    'branch' => $branchId,
                    'Qa' => $this->Qa
                ],
            ]);


            //$this->resetForm();

            session()->flash('message', 'تم الحجز بنجاح!');
        } else {
            session()->flash('error', 'يرجى التأكد من ملء جميع الحقول المطلوبة.');
        }
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
