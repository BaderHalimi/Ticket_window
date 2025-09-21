<?php

namespace App\Livewire\Merchant\Dashboard\Offers\Create;

use Livewire\Component;
use App\Models\Offering;
use Illuminate\Validation\Rule;

class Information extends Component
{
    public Offering $offering;

    public $name, $location, $description, $image;
    public $category, $type, $services_type, $center ;
    public $tags = [];
    public array $questions = [];
    public array $successFields = [];
    public array $errorFields = [];

    /**
     * Validation rules for Livewire
     */
    protected function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                // XSS Protection: Only allow safe characters
                'regex:/^[\p{L}\p{N}\s\-_.,!?()]+$/u',
                // SQL Injection Protection: Block dangerous patterns
                'not_regex:/(<script|javascript:|on\w+\s*=|<iframe|<object|<embed|eval\(|union\s+select|drop\s+table|delete\s+from|insert\s+into|update\s+set)/i',
                // Additional XSS protection
                function ($attribute, $value, $fail) {
                    if (containsXSSPatterns($value)) {
                        $fail(__('The :attribute contains potentially dangerous content.', ['attribute' => $attribute]));
                    }
                    if (containsSQLInjectionPatterns($value)) {
                        $fail(__('The :attribute contains invalid characters.', ['attribute' => $attribute]));
                    }
                },
            ],
            'location' => [
                Rule::requiredIf(function () {
                    return $this->type !== 'restaurant';
                }),
                'string',
                'min:3',
                'max:255',
                // XSS Protection: Only allow safe characters for location
                'regex:/^[\p{L}\p{N}\s\-_.,()\/]+$/u',
                // SQL Injection Protection
                'not_regex:/(<script|javascript:|on\w+\s*=|union\s+select|drop\s+table|delete\s+from|insert\s+into|update\s+set)/i',
                function ($attribute, $value, $fail) {
                    if (containsXSSPatterns($value)) {
                        $fail(__('The :attribute contains potentially dangerous content.', ['attribute' => $attribute]));
                    }
                    if (containsSQLInjectionPatterns($value)) {
                        $fail(__('The :attribute contains invalid characters.', ['attribute' => $attribute]));
                    }
                },
            ],
            'description' => [
                'required',
                'string',
                'min:10',
                'max:2000',
                // XSS Protection: Block script tags and dangerous patterns
                'not_regex:/(<script|<\/script|javascript:|on\w+\s*=|<iframe|<object|<embed|eval\()/i',
                // SQL Injection Protection
                'not_regex:/(union\s+select|drop\s+table|delete\s+from|insert\s+into|update\s+set|exec\s*\(|xp_cmdshell)/i',
                // Additional validation for description
                function ($attribute, $value, $fail) {
                    if (containsXSSPatterns($value) || containsSQLInjectionPatterns($value)) {
                        $fail(__('The :attribute contains potentially dangerous content.', ['attribute' => $attribute]));
                    }
                    if (containsExcessiveHTMLTags($value)) {
                        $fail(__('The :attribute contains too many HTML-like tags.', ['attribute' => $attribute]));
                    }
                },
            ],
            'type' => [
                'required',
                'string',
                'in:events,services,restaurant',
                // Extra protection for enum values
                'regex:/^[a-z_]+$/',
            ],
            'category' => [
                Rule::requiredIf(function () {
                    return in_array($this->type, ['events', 'services']);
                }),
                'string',
                'max:50',
                // Strict validation for category values
                'regex:/^[a-z_]+$/',
                Rule::when($this->type === 'events', Rule::in([
                    'conference', 'exhibition', 'children_event', 'online',
                    'workshop', 'social_party', 'sports_fitness',
                ])),
                Rule::when($this->type === 'services', Rule::in([
                    'digital', 'consulting', 'restaurant', 'educational',
                    'technical', 'personal', 'central', 'business',
                    'medical', 'real_estate', 'tourism', 'financial',
                    'maintenance', 'other',
                ])),
            ],
            'services_type' => [
                Rule::requiredIf(function () {
                    return !empty($this->category);
                }),
                'string',
                'max:100',
                // Strict validation for service type values
                'regex:/^[a-z_]+$/',
                // Additional validation against predefined list
                function ($attribute, $value, $fail) {
                    if (!empty($value) && !$this->isValidServiceType($value)) {
                        $fail(__('The selected :attribute is invalid.', ['attribute' => $attribute]));
                    }
                },
            ],
            'center' => [
                Rule::requiredIf(function () {
                    return $this->type === 'services';
                }),
                'string',
                'in:place,mobile',
                // Extra protection for enum values
                'regex:/^[a-z]+$/',
            ],
        ];
    }

    /**
     * Custom validation messages for Livewire
     */
    protected function messages()
    {
        return [
            'name.required' => __('Service name is required.'),
            'name.min' => __('Service name must be at least 3 characters.'),
            'name.max' => __('Service name cannot exceed 255 characters.'),
            'name.regex' => __('Service name contains invalid characters.'),

            'location.required' => __('Location is required.'),
            'location.min' => __('Location must be at least 3 characters.'),
            'location.max' => __('Location cannot exceed 255 characters.'),
            'location.regex' => __('Location contains invalid characters.'),

            'description.required' => __('Description is required.'),
            'description.min' => __('Description must be at least 10 characters.'),
            'description.max' => __('Description cannot exceed 2000 characters.'),

            'type.required' => __('Service type is required.'),
            'type.in' => __('Invalid service type selected.'),

            'category.required' => __('Category is required.'),
            'category.in' => __('Invalid category selected.'),

            'services_type.required' => __('Specific service type is required.'),
            'services_type.max' => __('Service type name is too long.'),

            'center.required' => __('Service location type is required.'),
            'center.in' => __('Invalid location type selected.'),
        ];
    }

    /**
     * Custom validation attributes for Livewire
     */
    protected function validationAttributes()
    {
        return [
            'name' => __('service name'),
            'location' => __('location'),
            'description' => __('description'),
            'type' => __('service type'),
            'category' => __('category'),
            'services_type' => __('specific service'),
            'center' => __('location type'),
        ];
    }

    public function mount(Offering $offering)
    {
        $this->offering = $offering;

        // Load basic fields
        foreach (['name', 'location', 'description', 'image', 'category', 'type'] as $field) {
            $this->{$field} = $offering->{$field};
        }

        // Load features
        $features = $offering->features ?? [];
        $this->center = $features['center'] ?? null;
        $this->services_type = $features['services_type'] ?? null;

        // Set default values
        if ($this->type === 'services' && empty($this->center)) {
            $this->center = '';
        }

        $this->dispatch('ServiceUpdated');
    }

    public function addQuestion()
    {
        $this->questions[] = [
            'question' => 'مكان السكن :',
            'translations' => [],
            'name' => 'location',
            'status' => 'critical',
        ];
    }

    /**
     * Save all form data with comprehensive validation
     */
    public function save()
    {
        // Clear previous errors
        $this->successFields = [];
        $this->errorFields = [];

        try {
            // Validate all fields at once
            $validatedData = $this->validate();

            // Additional business logic validations
            $this->performBusinessValidations();

            // Update the offering
            $this->updateOffering($validatedData);

            // Success message
            session()->flash('success', __('Information saved successfully!'));
            $this->dispatch('ServiceUpdated');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            foreach ($e->validator->errors()->messages() as $field => $messages) {
                $this->errorFields[$field] = $messages[0];
            }
            session()->flash('error', __('Please fix the validation errors.'));
        } catch (\Exception $e) {
            // Handle other errors
            session()->flash('error', __('An error occurred while saving: ') . $e->getMessage());
        }
    }

    /**
     * Perform additional business logic validations
     */
    protected function performBusinessValidations(): void
    {
        // Validate name uniqueness for the same user
        $existingOffering = \App\Models\Offering::where('name', $this->name)
            ->where('user_id', $this->offering->user_id)
            ->where('id', '!=', $this->offering->id)
            ->first();

        if ($existingOffering) {
            throw new \Exception(__('You already have a service with this name.'));
        }
    }

    /**
     * Update the offering with validated and sanitized data
     */
    protected function updateOffering(array $validatedData): void
    {
        // Sanitize and update basic fields
        foreach (['name', 'location', 'description', 'type', 'category'] as $field) {
            if (isset($validatedData[$field])) {
                // Apply additional sanitization
                $sanitizedValue = sanitizeInput($validatedData[$field]);
                $this->offering->{$field} = $sanitizedValue;
            }
        }

        // Update features array with sanitization
        $features = $this->offering->features ?? [];

        if (isset($validatedData['services_type'])) {
            $features['services_type'] = sanitizeInput($validatedData['services_type']);
        }

        if (isset($validatedData['center'])) {
            $features['center'] = sanitizeInput($validatedData['center']);
        }

        $this->offering->features = $features;

        // Handle location question for mobile services
        $this->handleLocationQuestion();

        // Set status to inactive when modified
        $this->offering->status = 'inactive';

        // Save the offering
        $this->offering->save();
    }

    /**
     * Handle location question for mobile services
     */
    protected function handleLocationQuestion(): void
    {
        if ($this->offering->type !== 'services') {
            return;
        }

        $locationQuestion = [
            'question' => __('Required location:'),
            'translations' => [],
            'name' => 'location',
            'status' => 'critical',
        ];

        $questions = $this->offering->additional_data['questions'] ?? [];

        if ($this->center === 'mobile') {
            // Add location question for mobile services
            $hasLocationQuestion = collect($questions)->contains(fn($q) =>
                ($q['status'] ?? null) === 'critical' &&
                ($q['name'] ?? null) === 'location'
            );

            if (!$hasLocationQuestion) {
                $questions[] = $locationQuestion;
            }
        } else {
            // Remove location question for fixed location services
            $questions = array_values(array_filter($questions, fn($q) =>
                !(($q['status'] ?? null) === 'critical' &&
                  ($q['name'] ?? null) === 'location')
            ));
        }

        $additionalData = $this->offering->additional_data ?? [];
        $additionalData['questions'] = $questions;
        $this->offering->additional_data = $additionalData;
    }

    public function updated($field)
    {
        // Clear previous messages for this field
        unset($this->successFields[$field]);
        unset($this->errorFields[$field]);

        // Handle field-specific logic
        $this->handleFieldUpdate($field);

        // Validate the specific field
        try {
            $this->validateOnly($field);
            $this->successFields[$field] =  __('Saved successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->errorFields[$field] = $e->validator->errors()->first($field);
        }

        // Save to database if validation passes
        if (!isset($this->errorFields[$field])) {
            $this->saveField($field);
        }
    }

    /**
     * Handle field-specific update logic
     */
    protected function handleFieldUpdate($field)
    {
        switch ($field) {
            case 'type':
                // Reset dependent fields when type changes
                if ($this->type !== $this->offering->type) {
                    $this->category = null;
                    $this->services_type = null;
                    $this->center = $this->type === 'services' ? '' : null;
                }
                break;

            case 'category':
                // Reset services_type when category changes
                if ($this->category !== $this->offering->category) {
                    $this->services_type = null;
                }
                break;

            case 'center':
                // Handle location question for mobile services
                $this->handleLocationQuestion();
                break;
        }
    }

    /**
     * Save individual field to database with sanitization
     */
    protected function saveField($field)
    {
        try {
            // Sanitize the field value before saving
            $sanitizedValue = sanitizeInput($this->{$field});

            if (in_array($field, ['services_type', 'center'])) {
                // Save to features array
                $features = $this->offering->features ?? [];
                $features[$field] = $sanitizedValue;
                $this->offering->features = $features;
            } else {
                // Save to main model fields
                $this->offering->{$field} = $sanitizedValue;
            }

            // Set status to inactive when modified
            $this->offering->status = 'inactive';
            $this->offering->save();

            $this->dispatch('ServiceUpdated');

        } catch (\Exception $e) {
            $this->errorFields[$field] = __('Error saving: ') . $e->getMessage();
        }
    }

    /**
     * Real-time validation for better UX
     */


    public function updatedType()
    {
        // Reset dependent fields when type changes
        $this->category = null;
        $this->services_type = null;

        if ($this->type === 'services') {
            $this->center = $this->center ?: '';
        } else {
            $this->center = null;
        }

    }

    public function updatedCategory()
    {
        // Reset services_type when category changes
        $this->services_type = null;
        // $this->validateOnly('category');
    }

    /**
     * Check if form is valid for submission
     */
    public function getIsValidProperty(): bool
    {
        try {
            $this->validate();
            return true;
        } catch (\Illuminate\Validation\ValidationException $e) {
            return false;
        }
    }

    /**
     * Get completion percentage
     */
    public function getCompletionPercentageProperty(): int
    {
        $requiredFields = ['name', 'description', 'type'];

        if ($this->type !== 'restaurant') {
            $requiredFields[] = 'location';
        }

        if (in_array($this->type, ['events', 'services'])) {
            $requiredFields[] = 'category';
            $requiredFields[] = 'services_type';
        }

        if ($this->type === 'services') {
            $requiredFields[] = 'center';
        }

        $completedFields = 0;
        foreach ($requiredFields as $field) {
            if (!empty($this->{$field})) {
                $completedFields++;
            }
        }

        return round(($completedFields / count($requiredFields)) * 100);
    }



    /**
     * Get allowed categories for a given type
     */
    protected function getAllowedCategories($type): array
    {
        $categories = [
            'events' => [
                'conference', 'exhibition', 'children_event', 'online',
                'workshop', 'social_party', 'sports_fitness'
            ],
            'services' => [
                'digital', 'consulting', 'restaurant', 'educational',
                'technical', 'personal', 'central', 'business',
                'medical', 'real_estate', 'tourism', 'financial',
                'maintenance', 'other'
            ],
            'restaurant' => []
        ];

        return $categories[$type] ?? [];
    }

    /**
     * Get allowed service types for a given category
     */
    protected function getAllowedServiceTypes($category): array
    {
        $serviceTypes = [
            // Events
            'conference' => [
                'tech_conference', 'business_conference', 'medical_conference',
                'educational_conference', 'cultural_conference', 'scientific_conference', 'press_conference'
            ],
            'exhibition' => [
                'art_exhibition', 'tech_exhibition', 'trade_exhibition',
                'fashion_exhibition', 'car_exhibition', 'book_fair', 'food_exhibition'
            ],
            'children_event' => [
                'kids_show', 'kids_workshop', 'kids_party',
                'kids_festival', 'storytelling_event', 'kids_theater'
            ],
            'online' => [
                'webinar', 'online_training', 'virtual_meeting',
                'online_conference', 'online_workshop', 'online_show'
            ],
            'workshop' => [
                'technical_workshop', 'art_workshop', 'business_training',
                'language_course', 'photography_workshop', 'culinary_workshop'
            ],
            'social_party' => [
                'wedding', 'birthday', 'community_event',
                'graduation_party', 'charity_event', 'family_gathering'
            ],
            'sports_fitness' => [
                'marathon', 'fitness_class', 'tournament',
                'football_match', 'basketball_match', 'yoga_session', 'cycling_event'
            ],

            // Services
            'digital' => [
                'graphic_design', 'web_development', 'app_development',
                'video_editing', 'content_writing', 'translation', 'seo', 'digital_marketing'
            ],
            'consulting' => [
                'financial_consulting', 'legal_consulting', 'marketing_consulting',
                'tech_consulting', 'engineering_consulting'
            ],
            'educational' => [
                'online_courses', 'workshops', 'coaching', 'educational_content'
            ],
            'technical' => [
                'tech_support', 'device_maintenance', 'hosting', 'server_management'
            ],
            'personal' => [
                'photography', 'videography', 'interior_design', 'event_planning', 'fitness_training'
            ],
            'central' => [
                'restaurants', 'cafes', 'theaters', 'cinemas', 'party_halls',
                'conference_halls', 'arcades', 'equipment_rental', 'car_rental',
                'bike_rental', 'clothing_rental'
            ],
            'business' => [
                'shipping', 'inventory_management', 'packaging', 'warehousing'
            ],
            'medical' => [
                'online_medical_consulting', 'lab_tests', 'physiotherapy'
            ],
            'real_estate' => [
                'property_sales', 'property_rental', 'property_management', 'property_valuation'
            ],
            'tourism' => [
                'ticket_booking', 'trip_planning', 'hotel_booking'
            ],
            'financial' => [
                'money_transfer', 'loans', 'investment', 'portfolio_management'
            ],
            'maintenance' => [
                'car_repair', 'bike_repair', 'ac_maintenance', 'computer_repair',
                'phone_repair', 'plumbing', 'electrical', 'furniture_repair',
                'home_appliance_repair', 'elevator_maintenance', 'door_window_repair',
                'agriculture_tools_repair'
            ],
            'other' => ['other'],
        ];

        return $serviceTypes[$category] ?? [];
    }

    /**
     * Check if service type is valid for current category
     */
    protected function isValidServiceType($serviceType): bool
    {
        if (empty($this->category)) {
            return false;
        }

        $allowedTypes = $this->getAllowedServiceTypes($this->category);
        return in_array($serviceType, $allowedTypes, true);
    }



    public function render()
    {
        return view('livewire.merchant.dashboard.offers.create.information');
    }
}
