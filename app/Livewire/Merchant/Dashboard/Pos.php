<?php

namespace App\Livewire\Merchant\Dashboard;

use App\Models\Offering;
use App\Models\PaidReservation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Pos extends Component
{
    public $offerings;
    public $selectedOfferingId;
    public $selectedPackage;
    public $pricingPackages = [];
    public $tickets = 1;
    public $manualPrice = 0;
    public $paymentMethod;

    public $customerName;
    public $customerPhone;
    public $customerEmail;

    public $foundUser = null;

    public function mount()
    {
        $this->offerings = Offering::where('user_id', Auth::id())->get();
    }

    public function updatedSelectedOfferingId($value)
    {
        $offering = $this->offerings->firstWhere('id', $value);
        if (!$offering) {
            $this->pricingPackages = [];
            return;
        }

        $features = $offering->features;
        $packages = $features['pricing_packages'] ?? [];

        $this->pricingPackages = collect($packages)
            ->filter(fn($pkg) => !empty($pkg['label']) && $pkg['price'] > 0)
            ->values()
            ->toArray();
    }

    public function updatedCustomerEmail($value)
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $value)->first();
            if ($user) {
                $this->foundUser = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'profile_image' => $user->additional_data['profile_image'] ?? '/default-avatar.png',
                ];
                $this->customerName = $user->name;
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
            'paymentMethod' => 'required|in:cash,vip,free',
            'customerPhone' => 'required|string',
            'customerEmail' => 'nullable|email',
        ]);

        $price = 0;
        if ($this->selectedPackage) {
            $price = collect($this->pricingPackages)
                ->firstWhere('label', $this->selectedPackage)['price'] ?? 0;
        } else {
            $price = $this->manualPrice;
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
            ]),
        ]);

        session()->flash('success', 'تم إنشاء الحجز بنجاح!');
        $this->reset([
            'selectedOfferingId',
            'selectedPackage',
            'tickets',
            'manualPrice',
            'paymentMethod',
            'customerName',
            'customerPhone',
            'customerEmail',
            'foundUser',
            'pricingPackages'
        ]);
    }

    public function render()
    {
        return view('livewire.merchant.dashboard.pos');
    }
}
