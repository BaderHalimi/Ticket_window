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
    public $category, $type, $services_type, $center;
    public $tags = [];
    public array $successFields = [];
    public array $errorFields = [];

    public function mount(Offering $offering)
    {
        $this->offering = $offering;
        foreach (
            [
                'name',
                'location',
                'description',
                'image',
                'category',
                'type'
            ] as $field
        ) {
            $this->{$field} = $offering->{$field};
        }
        $this->center = $offering->features['center'] ?? null;
        $this->dispatch('ServiceUpdated');
    }

    public function updated($field)
    {
        unset($this->successFields[$field]);
        unset($this->errorFields[$field]);

        $rules = [
            'name' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'type' => 'nullable|in:events,services',
            'category' => 'required|in:conference,exhibition,children_event,sports_fitness,online,workshop,social_party,seasonal,on_demand,vip',
            'center' => [
                Rule::requiredIf(function () {
                    return $this->type == 'services';
                }),
                Rule::in(['place', 'mobile']),
            ]
        ];

        try {
            $this->validateOnly($field, $rules);

            if ($field === 'center') {
                $this->offering->features = array_merge(
                    $this->offering->features ?? [],
                    ['center' => $this->center]
                );
            } else {
                $this->offering->{$field} = $this->{$field};
            }

            $this->offering->status = 'inactive';
            $this->offering->save();
            $this->dispatch('ServiceUpdated');
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
