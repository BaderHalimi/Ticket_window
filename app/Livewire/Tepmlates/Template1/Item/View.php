<?php

namespace App\Livewire\Tepmlates\Template1\Item;

use App\Models\Cart;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class View extends Component
{
    public $offer;
    public $availableDays = [];
    public $currentMonth;
    public $currentYear;
    public $selectedDate = null;
    public $selectedTime = null;
    public $timeSlots = [];
    public $daysLimit = 3;

    public $count = 1;
    public $price = 0;
    public $couponCode = '';

    public function mount($offer, $daysLimit = 0)
    {
        $this->offer = $offer;
        $this->daysLimit = $daysLimit;
        $this->currentMonth = request()->get('month', now()->month);
        $this->currentYear = request()->get('year', now()->year);

        $this->generateAvailableDays();
        $this->calcPrice();
    }

    public function generateAvailableDays()
    {
        $this->availableDays = [];
        $start = now()->startOfDay();

        for ($i = 0; $i < $this->daysLimit; $i++) {
            $this->availableDays[] = $start->copy()->addDays($i)->toDateString();
        }
    }

    public function nextMonth()
    {
        $next = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->currentMonth = $next->month;
        $this->currentYear = $next->year;
        $this->selectedDate = null;
        $this->generateTimeSlots();
    }

    public function prevMonth()
    {
        $prev = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->subMonth();
        $this->currentMonth = $prev->month;
        $this->currentYear = $prev->year;
        $this->selectedDate = null;
        $this->generateTimeSlots();
    }

    public function selectDate($day)
    {
        $selected = Carbon::create($this->currentYear, $this->currentMonth, $day)->toDateString();

        if ($this->availableDays != []) {
            if (in_array($selected, $this->availableDays)) {
                $this->selectedDate = $selected;
                $this->generateTimeSlots();
            }
        } elseif ($selected > now()->subDay()->toDateString()) {
            $this->selectedDate = $selected;
            $this->generateTimeSlots();
        }
    }

    public function checkTime($time)
    {
        if (!in_array($time, $this->timeSlots)) return false;

        $selectedTime = Carbon::parse($this->selectedDate . ' ' . $time);
        $bookingDeadline = now()->addMinutes($this->offer->features['booking_minimum_time'] ?? 0);

        return $selectedTime->gte($bookingDeadline);
    }
    public function selectTime($time)
    {
        if (in_array($time, $this->timeSlots)) {
            if (Carbon::parse($this->selectedDate)->isSameDay(now())) {
                if (Carbon::parse(now()->format('Y-m-d') . ' ' . $time) >= now()->addMinutes($this->offer->features['booking_minimum_time'] ?? 0))
                    $this->selectedTime = $time;
            } else {
                $this->selectedTime = $time;
            }
        } else {
            $this->selectedTime = null;
        }
    }

    public function subNumber()
    {
        if ($this->count > 1) {
            $this->count--;
        }
        $this->calcPrice();
    }

    public function addNumber()
    {
        $this->count++;
        $this->calcPrice();
    }

    public function calcPrice()
    {
        $base = $this->offer->features['base_price'] ?? 0;
        $price = $base * $this->count;

        // Check for discount
        if (!empty($this->offer->features['enable_discounts']) && $this->offer->features['enable_discounts']) {
            $now = now();
            $start = Carbon::parse($this->offer->features['discount_start']);
            $end = Carbon::parse($this->offer->features['discount_end']);
            if ($now->between($start, $end)) {
                $discount = (float) $this->offer->features['discount_percent'];
                $price -= ($price * $discount / 100);
            }
        }

        // Apply coupon
        if (!empty($this->couponCode)) {
            $coupons = $this->offer->features['coupons'] ?? [];
            foreach ($coupons as $coupon) {
                if (strtoupper($coupon['code']) === strtoupper($this->couponCode) && now()->lte($coupon['expires_at'])) {
                    $discount = (float) $coupon['discount'];
                    $price -= ($price * $discount / 100);
                }
            }
        }
        $this->price = max(0, $price);
    }

    public function generateTimeSlots()
    {
        $this->selectedTime = null;
        $this->timeSlots = [];

        $duration = $this->offer->features['booking_duration'] ?? 1;
        $unit = $this->offer->features['booking_unit'] ?? 'hour';

        if (!$this->selectedDate) return;

        $interval = match ($unit) {
            'hour' => $duration * 60,
            'minute' => $duration,
            'quarter' => $duration * 15,
            'day' => $duration * 24 * 60,
            default => 60,
        };

        $start = Carbon::parse($this->selectedDate . ' 08:00');
        $end = Carbon::parse($this->selectedDate . ' 20:00');

        while ($start->lt($end)) {
            $this->timeSlots[] = $start->format('h:i A');
            $start->addMinutes($interval);
        }
    }

    public function addToCart()
    {
        $user = Auth::guard('customer')->user();
        if (!$user || !$this->selectedDate || !$this->selectedTime) {
            session()->flash('error', 'يرجى اختيار التاريخ والوقت أولاً.');
            return;
        }

        Cart::create([
            'user_id' => $user->id,
            'item_id' => $this->offer->id,
            'item_type' => get_class($this->offer),
            'quantity' => $this->count,
            'price' => $this->price,
            'discount' => 0, // الخصم مُطبق مسبقًا ضمن السعر
            'additional_data' => json_encode([
                'selected_date' => $this->selectedDate,
                'selected_time' => $this->selectedTime,
                'coupon_code' => $this->couponCode,
            ]),
        ]);

        session()->flash('success', 'تمت إضافة الحجز إلى السلة بنجاح.');
        // return redirect()->route('cart.index');
        $this->redirectIntended(route('template1.cart', ['id' => $this->offer->user_id]), true);
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
