<?php

namespace App\Livewire\Templates\Template1;

use Livewire\Component;
use App\Models\Offering;

class View extends Component
{   
    public $offering;
    public function mount($id){
        $this->offering = Offering::findOrFail($id);
        //dd($this->offering);

    }
    public function render()
    {
        return view('livewire.templates.template1.view');
    }
}
