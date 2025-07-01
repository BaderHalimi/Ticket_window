<?php

namespace App\Livewire\Merchant\Dashboard;

use App\Models\Offering;
use App\Models\PaidReservation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Carbon\Carbon;

class Pos extends Component
{
    public $offerings;
    public $selectedOfferingId;
    public $pricingPackages = [];
    public $selectedPackage;
    public $showPackage = false;

    public $tickets = 1;
    public $manualPrice = 0;
    public $paymentMethod;

    public $customerEmail;
    public $customerName;
    public $customerPhone;
    public $foundUser = null;

    public $selectedDate;
    public $selectedTime;

    public $allowedDates = [];
    public $allowedTimes = [];

    public function mount()
    {
        $this->offerings = Offering::where('user_id', Auth::id())->get();
    }

    public function updatedSelectedOfferingId($value)
    {
        $offering = $this->offerings->firstWhere('id', $value);

        if (!$offering) {
            $this->pricingPackages = [];
            $this->allowedDates = [];
            $this->allowedTimes = [];
            return;
        }

        $features = $offering->features ?? [];
        $this->pricingPackages = collect($features['pricing_packages'] ?? [])
            ->filter(fn($pkg) => !empty($pkg['label']) && $pkg['price'] > 0)
            ->values()
            ->toArray();

        $this->buildAllowedDatesAndTimes($offering, $features);
    }

    public function buildAllowedDatesAndTimes($offering, $features)
    {
        $this->allowedDates = [];
        $this->allowedTimes = [];

        if ($offering->type === 'event') {
            $start = Carbon::parse($offering->start_date);
            $end = Carbon::parse($offering->end_date);

            foreach ($start->daysUntil($end) as $date) {
                $dateStr = $date->toDateString();
                $this->allowedDates[] = $dateStr;
                $this->allowedTimes[$dateStr] = [
                    'start' => $start->format('H:i'),
                    'end' => $end->format('H:i')
                ];
            }
        } else {
            $workSchedule = $features['work_schedule'] ?? [];
            $closedDays = $features['closed_days'] ?? [];

            for ($i = 0; $i < 30; $i++) {
                $date = now()->addDays($i);
                $dateStr = $date->toDateString();
                $day = strtolower($date->englishDayOfWeek);

                if (in_array($dateStr, $closedDays)) continue;
                if (($workSchedule[$day]['enabled'] ?? false)) {
                    $this->allowedDates[] = $dateStr;
                    $this->allowedTimes[$dateStr] = [
                        'start' => $workSchedule[$day]['start'],
                        'end' => $workSchedule[$day]['end']
                    ];
                }
            }
        }
    }

    public function updatedCustomerEmail($value)
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $value)->first();
            if ($user) {
                $this->foundUser = [
                    'id' => $user->id,
                    'name' => $user->f_name,
                    'email' => $user->email,
                    'profile_image' => $user->additional_data['profile_image'] ?? '/default-avatar.png',
                ];
                $this->customerName = $user->f_name;
                $this->customerPhone = $user->phone ?? '';
            } else {
                $this->foundUser = null;
            }
        } else {
            $this->foundUser = null;
        }
    }

    public function createBooking()
    {
        $this->validate([
            'selectedOfferingId' => 'required|exists:offerings,id',
            'selectedDate' => 'required|date',
            'selectedTime' => 'required|date_format:H:i',
            'paymentMethod' => 'required|in:cash,free',
            'customerPhone' => 'required|string',
        ]);

        if (!in_array($this->selectedDate, $this->allowedDates)) {
            session()->flash('error', 'التاريخ غير متاح للحجز');
            return;
        }

        $offering = $this->offerings->firstWhere('id', $this->selectedOfferingId);
        $selectedDateTime = Carbon::parse("{$this->selectedDate} {$this->selectedTime}");

        if ($offering->type === 'event') {
            $eventStart = Carbon::parse($offering->start_date);
            $eventEnd = Carbon::parse($offering->end_date);
            if ($selectedDateTime->lt($eventStart) || $selectedDateTime->gt($eventEnd)) {
                session()->flash('error', 'الوقت خارج نطاق الفعالية');
                return;
            }
        } else {
            $features = $offering->features ?? [];
            $workSchedule = $features['work_schedule'] ?? [];
            $day = strtolower(Carbon::parse($this->selectedDate)->englishDayOfWeek);
            if (!($workSchedule[$day]['enabled'] ?? false)) {
                session()->flash('error', 'اليوم غير موجود في أيام العمل');
                return;
            }
        }

        $price = 0;
        if ($this->paymentMethod === 'cash') {
            if ($this->showPackage && $this->selectedPackage) {
                $price = collect($this->pricingPackages)
                    ->firstWhere('label', $this->selectedPackage)['price'] ?? 0;
            } else {
                $price = $this->manualPrice;
            }
        }

        PaidReservation::create([
            'item_id' => $this->selectedOfferingId,
            'item_type' => Offering::class,
            'user_id' => $this->foundUser['id'] ?? Auth::id(),
            'quantity' => $this->tickets,
            'price' => $price,
            'discount' => 0,
            'code' => uniqid('code_'),
            'additional_data' => json_encode([
                'customerName' => $this->customerName,
                'customerPhone' => $this->customerPhone,
                'customerEmail' => $this->customerEmail,
                'paymentMethod' => $this->paymentMethod,
                'selling_type' => 'pos',
                'selected_date' => $this->selectedDate,
                'selected_time' => Carbon::createFromFormat('H:i', $this->selectedTime)->format('h:i A'),
            ]),
        ]);

        session()->flash('success', 'تم إنشاء الحجز بنجاح!');
        $this->reset([
            'selectedOfferingId',
            'pricingPackages',
            'selectedPackage',
            'showPackage',
            'tickets',
            'manualPrice',
            'paymentMethod',
            'customerEmail',
            'customerName',
            'customerPhone',
            'foundUser',
            'selectedDate',
            'selectedTime',
            'allowedDates',
            'allowedTimes',
        ]);
    }

    public function render()
    {
        return view('livewire.merchant.dashboard.pos');
    }
}
