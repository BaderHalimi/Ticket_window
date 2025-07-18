<?php

namespace App\Livewire\Templates;

use Livewire\Component;
use App\Models\User;
use App\Models\Offering;
use Illuminate\Support\Facades\Auth;

class TemplateRouter extends Component
{
    public $merchant;
    public $offers_collection;

    public function mount($merchant, $offers_collection = null)
    {
        $this->offers_collection = Offering::where('user_id', $this->merchant->id)->where('status', 'active')->get();
        
        //dd($this->offers_collection, $this->merchant);
    }
    public function render()
    {
        //dd($this->merchant);

        return view('livewire.templates.template1.index');
    }
}
