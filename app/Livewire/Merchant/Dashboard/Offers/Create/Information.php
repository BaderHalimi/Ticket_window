<?php

namespace App\Livewire\Merchant\Dashboard\Offers\Create;

use Livewire\Component;
use App\Models\Offering;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class Information extends Component
{
    public Offering $offering;

    public $name, $location, $description, $image;
    public  $category, $type, $services_type;
    //public $has_chairs, $chairs_count; $start_time, $end_time, $status, $type,, $price
    public $tags = [];
    public array $successFields = [];
    public array $errorFields = [];

    public function mount(Offering $offering)
    {
        $this->offering = $offering;
        $this->services_type = $this->offering->features['services_type'];
        foreach (
            [
                'name',
                'location',
                'description',
                'image',
                'category' //,'type'
                //'start_time', 'end_time', 'status', 'type', 'category', 'price',
                //'has_chairs', 'chairs_count'
            ] as $field
        ) {
            $this->{$field} = $offering->{$field};
        }
        $this->dispatch('ServiceUpdated');

        //$this->start_time = $offering->start_time ? $offering->start_time->format('Y-m-d H:i') : null;
        //$this->end_time = $offering->end_time ? $offering->end_time->format('Y-m-d H:i') : null;
    }

    public function updated($field)
    {
        // Clear old messages
        unset($this->successFields[$field]);
        unset($this->errorFields[$field]);

        // Define validation rules per field
        $rules = [
            'name' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            //'price' => 'nullable|numeric|min:0',
            //'start_time' => 'nullable|date',
            //'end_time' => 'nullable|date|after_or_equal:start_time',
            //'status' => 'nullable|in:active,inactive',
            //'type' => 'nullable|in:event,services',
            'category' => 'nullable|in:vip,one_day,several_days,reapeted',
            //'has_chairs' => 'boolean',
            //'chairs_count' => 'required_if:has_chairs,true|integer|min:0',
        ];



        try {
            // validate only updated field
            $this->validateOnly($field, $rules);

            // Update value
            if ($field == 'services_type') {
                $features = $this->offering->features ?? [];
                $features['services_type'] = $this->services_type;
                //$features['tags'] = $this->tags;
                $this->offering->features = $features;
            } else
                $this->offering->{$field} = $this->{$field};


            $this->offering->status = 'inactive';
            $this->offering->save();
            $this->dispatch('ServiceUpdated');
            // Show success message
            $this->successFields[$field] = 'تم الحفظ بنجاح ✅';
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->errorFields[$field] = $e->validator->errors()->first($field);
        }
    }

    public function render()
    {
        return view('livewire.merchant.dashboard.offers.create.information');
    }
}
