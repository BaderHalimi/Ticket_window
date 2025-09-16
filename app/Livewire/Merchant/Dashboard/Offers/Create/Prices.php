<?php

namespace App\Livewire\Merchant\Dashboard\Offers\Create;

use Livewire\Component;
use App\Models\Offering;
use Illuminate\Support\Facades\Log;

class Prices extends Component
{
    public Offering $offering;

    // Toggles
    public bool $enable_base_price = false;
    //public bool $enable_hourly_pricing = false;
    public bool $enable_coupons = false;
    public bool $enable_discounts = false;
    public bool $enable_cancellation = false;
    //public bool $enable_cancellation_fee = false;
    //public bool $enable_cancellation_deadline = false;
    public bool $enable_pricing_packages = false;

    // Inputs
    public $base_price = 0.0;
    //public $hourly_rate = 0.0;
    public $cancellation_fee = 0.0;
    public $cancellation_deadline_minutes = '';

    public array $pricing_packages = [
        ['label' => 'شخص واحد', 'price' => 0],
    ];

    public array $coupons = [
        ['code' => '', 'discount' => 0, 'expires_at' => '']
    ];
    public $discount_start = '';
    public $discount_end = '';
    public $discount_percent = null;

    // Additional properties for the new UI
    public $discount = null;
    public $min_booking = 1;
    public $max_booking = 10;

    protected $rules = [
        'base_price' => [
            'required',
            'numeric',
            'min:0.01',
            'max:999999.99',
            'regex:/^\d+(\.\d{1,2})?$/'
        ],
        'discount' => [
            'nullable',
            'numeric',
            'min:0',
            'max:100',
            'regex:/^\d+(\.\d{1,2})?$/'
        ],
        'min_booking' => [
            'required',
            'integer',
            'min:1',
            'max:1000'
        ],
        'max_booking' => [
            'required',
            'integer',
            'min:1',
            'max:10000'
        ],
        'discount_percent' => [
            'nullable',
            'numeric',
            'min:1',
            'max:100'
        ],
        'discount_start' => [
            'nullable',
            'date',
            'after_or_equal:today'
        ],
        'discount_end' => [
            'nullable',
            'date',
            'after:discount_start'
        ],
        'coupons.*.code' => [
            'nullable',
            'string',
            'max:50',
            'regex:/^[A-Z0-9_-]+$/i'
        ],
        'coupons.*.type' => [
            'nullable',
            'string',
            'in:percentage,fixed'
        ],
        'coupons.*.discount' => [
            'nullable',
            'numeric',
            'min:0.01'
        ],
        'coupons.*.expires_at' => [
            'nullable',
            'date',
            'after:today'
        ],
        'pricing_packages.*.label' => [
            'nullable',
            'string',
            'max:100'
        ],
        'pricing_packages.*.price' => [
            'nullable',
            'numeric',
            'min:0.01',
            'max:999999.99'
        ]
    ];

    /**
     * Custom validation messages
     */
    protected function messages()
    {
        return [
            'base_price.required' => __('Base price is required'),
            'base_price.numeric' => __('Base price must be a valid number'),
            'base_price.min' => __('Base price must be at least 0.01 SAR'),
            'base_price.max' => __('Base price cannot exceed 999,999.99 SAR'),
            'base_price.regex' => __('Base price format is invalid (max 2 decimal places)'),

            'discount.numeric' => __('Discount must be a valid number'),
            'discount.min' => __('Discount cannot be negative'),
            'discount.max' => __('Discount cannot exceed 100%'),
            'discount.regex' => __('Discount format is invalid (max 2 decimal places)'),

            'min_booking.required' => __('Minimum booking is required'),
            'min_booking.integer' => __('Minimum booking must be a whole number'),
            'min_booking.min' => __('Minimum booking must be at least 1'),
            'min_booking.max' => __('Minimum booking cannot exceed 1,000'),

            'max_booking.required' => __('Maximum booking is required'),
            'max_booking.integer' => __('Maximum booking must be a whole number'),
            'max_booking.min' => __('Maximum booking must be at least 1'),
            'max_booking.max' => __('Maximum booking cannot exceed 10,000'),

            'discount_start.date' => __('Discount start date must be a valid date'),
            'discount_start.after_or_equal' => __('Discount start date cannot be in the past'),

            'discount_end.date' => __('Discount end date must be a valid date'),
            'discount_end.after' => __('Discount end date must be after start date'),

            'coupons.*.code.string' => __('Coupon code must be text'),
            'coupons.*.code.max' => __('Coupon code cannot exceed 50 characters'),
            'coupons.*.code.regex' => __('Coupon code can only contain letters, numbers, hyphens and underscores'),

            'coupons.*.discount.numeric' => __('Coupon discount must be a number'),
            'coupons.*.discount.min' => __('Coupon discount must be at least 1%'),
            'coupons.*.discount.max' => __('Coupon discount cannot exceed 100%'),

            'pricing_packages.*.label.string' => __('Package label must be text'),
            'pricing_packages.*.label.max' => __('Package label cannot exceed 100 characters'),
            'pricing_packages.*.price.numeric' => __('Package price must be a number'),
            'pricing_packages.*.price.min' => __('Package price must be at least 0.01 SAR'),
            'pricing_packages.*.price.max' => __('Package price cannot exceed 999,999.99 SAR')
        ];
    }

    public function mount(Offering $offering)
    {
        $this->offering = $offering;

        $features = $offering->features ?? [];
        //dd($this->base_price);
        $this->fill(array_merge([
            //'base_price' => false,
            //'base_price' => 0.0,
            'enable_hourly_pricing' => false,
            //'hourly_rate' => 0.0,
            'enable_coupons' => false,
            'enable_discounts' => false,

            'discount_start' => '',
            'discount_end' => '',
            'discount_percent' => null,

            'enable_cancellation' => false,
            //'enable_cancellation_fee' => false,
            'cancellation_fee' => 0.0,
            //'enable_cancellation_deadline' => false,
            'cancellation_deadline_minutes' => '',
            'enable_pricing_packages' => false,
            'pricing_packages' => [
                ['label' => 'شخص واحد', 'price' => 0],
            ],
            'coupons' => [
                ['code' => '', 'discount' => 0, 'expires_at' => '']
            ]
            //'enable_discounts' => false,

        ], $features));
        $this->base_price = $this->offering->price ?? 0.0;

    }



    public function savePricingSettings()
    {
        $this->offering->update([

            'features' => array_merge($this->offering->features ?? [], [
                //'base_price' => (float) $this->base_price,
                //'enable_hourly_pricing' => $this->enable_hourly_pricing,
                //'hourly_rate' => (float) $this->hourly_rate,
                'enable_coupons' => $this->enable_coupons,
                'coupons' => $this->coupons,
                'enable_discounts' => $this->enable_discounts,
                'enable_cancellation' => $this->enable_cancellation,
                //'enable_cancellation_fee' => $this->enable_cancellation_fee,
                'cancellation_fee' => (float) $this->cancellation_fee,
                //'enable_cancellation_deadline' => $this->enable_cancellation_deadline,
                'cancellation_deadline_minutes' => (int) $this->cancellation_deadline_minutes,
                'enable_pricing_packages' => $this->enable_pricing_packages,
                'pricing_packages' => $this->pricing_packages,
                'discount_start' => $this->discount_start,
                'discount_end' => $this->discount_end,
                'discount_percent' => $this->discount_percent,

            ]),
            'status' => 'inactive'
        ]);
        $this->offering->price = (float) $this->base_price;
        $this->offering->save();

        $this->dispatch('ServiceUpdated');

        session()->flash('success', 'تم حفظ إعدادات التسعير بنجاح');
    }
    public function removePackage($index)
    {
        unset($this->pricing_packages[$index]);
        $this->pricing_packages = array_values($this->pricing_packages); // لإعادة ترتيب المؤشرات
        $this->savePricingSettings(); // حفظ تلقائي بعد الحذف
    }
    public function addPackage()
    {
        $this->pricing_packages[] = ['label' => '', 'price' => 0];
        $this->savePricingSettings();
    }

    public function addCoupon()
    {
        $this->coupons[] = ['code' => '', 'discount' => 0, 'expires_at' => ''];
        $this->savePricingSettings();
    }


    public function removeCoupon($index)
    {
        unset($this->coupons[$index]);
        $this->coupons = array_values($this->coupons);
        $this->savePricingSettings();
    }

    public function updated($propertyName)
    {
        try {
            // Skip validation for certain properties to prevent loops
            if (in_array($propertyName, ['offering', 'errors'])) {
                return;
            }

            // Sanitize input to prevent XSS
            $this->sanitizeProperty($propertyName);

            // Validate the specific property
            $this->validateOnly($propertyName);

            // Custom validation logic
            $this->customValidation($propertyName);

            // Save changes
            $this->savePricingSettings();

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors gracefully
            foreach ($e->errors() as $field => $messages) {
                $this->addError($field, $messages[0]);
            }
        } catch (\Exception $e) {
            Log::error('Prices component update error: ' . $e->getMessage(), [
                'property' => $propertyName,
                'offering_id' => $this->offering->id ?? null,
                'trace' => $e->getTraceAsString()
            ]);
            $this->addError($propertyName, __('An error occurred while updating. Please try again.'));
        }
    }

    /**
     * Sanitize property to prevent XSS and SQL injection
     */
    private function sanitizeProperty($propertyName)
    {
        $value = data_get($this, $propertyName);

        if (is_string($value)) {
            // Use global sanitizeInput function if available
            if (function_exists('sanitizeInput')) {
                $sanitizedValue = sanitizeInput($value);
            } else {
                // Fallback sanitization
                $sanitizedValue = htmlspecialchars(strip_tags(trim($value)), ENT_QUOTES, 'UTF-8');
            }

            data_set($this, $propertyName, $sanitizedValue);
        }
    }

    /**
     * Custom validation logic
     */
    private function customValidation($propertyName)
    {
        // Validate max_booking is greater than min_booking
        if ($propertyName === 'max_booking' || $propertyName === 'min_booking') {
            if ($this->min_booking && $this->max_booking && $this->min_booking > $this->max_booking) {
                $this->addError('max_booking', __('Maximum booking must be greater than minimum booking'));
            }
        }

        // Validate discount percentage
        if ($propertyName === 'discount') {
            if ($this->discount && ($this->discount < 0 || $this->discount > 100)) {
                $this->addError('discount', __('Discount must be between 0% and 100%'));
            }
        }

        // Validate base price
        if ($propertyName === 'base_price') {
            if ($this->base_price && $this->base_price <= 0) {
                $this->addError('base_price', __('Base price must be greater than 0'));
            }
        }

        // Validate scheduled discounts
        if ($propertyName === 'enable_discounts' || in_array($propertyName, ['discount_start', 'discount_end', 'discount_percent'])) {
            $this->validateScheduledDiscounts();
        }

        // Validate coupon codes for uniqueness
        if (str_contains($propertyName, 'coupons.') && str_contains($propertyName, '.code')) {
            $this->validateCouponUniqueness();
        }

        // Validate coupon discount based on type
        if (str_contains($propertyName, 'coupons.') && (str_contains($propertyName, '.discount') || str_contains($propertyName, '.type'))) {
            $this->validateCouponDiscount($propertyName);
        }
    }

    /**
     * Validate coupon code uniqueness
     */
    private function validateCouponUniqueness()
    {
        $codes = collect($this->coupons)->pluck('code')->filter()->toArray();
        $duplicates = array_diff_assoc($codes, array_unique($codes));

        if (!empty($duplicates)) {
            $this->addError('coupons', __('Coupon codes must be unique'));
        }
    }

    public function render()
    {
        //dd($this->base_price);
        return view('livewire.merchant.dashboard.offers.create.prices');
    }
}
