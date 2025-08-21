<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\setup;
//use DragonCode\Contracts\Cashier\Auth\Auth;
use Illuminate\Support\Facades\Auth;
class GeneralSetup extends Component
{
    use WithFileUploads;

    public $tab = 'general';
    public $logo;
    public $setup;

    // Editable fields
    public $name;
    public $email;
    public $phone;
    public $social_links = [];
    public $additional_data = [];

    public function mount()
    {
        $this->setup = Setup::firstOrCreate(
            //['id' => 1],
            //['name' => '']
        );
        
        $this->name = $this->setup->name;
        $this->email = $this->setup->email;
        $this->phone = $this->setup->phone;
        $this->social_links = $this->setup->social_links ?? [];
        $this->additional_data = $this->setup->additional_data ?? [];

    }

    public function save()
    {
        if(isset($this->setup->additional_data["owner"])){
            if ($this->setup->additional_data["owner"] != Auth::guard("admin")->user()->id) {
                session()->flash('error', '❌ لا يمكنك تعديل الإعدادات');
                return;
            }
        }else{
            $this->additional_data["owner"] = Auth::guard("admin")->user()->id;

        }

        if ($this->logo) {
            $path = $this->logo->store('logos', 'public');
            $this->setup->logo = $path;
        }

        $this->setup->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'social_links' => $this->social_links,
            'additional_data' => $this->additional_data,
        ]);

        session()->flash('success', '✅ تم حفظ الإعدادات بنجاح');
    }

    public function render()
    {
        return view('livewire.general-setup');
    }
}
