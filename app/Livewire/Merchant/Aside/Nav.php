<?php

namespace App\Livewire\Merchant\Aside;

use Livewire\Component;

class Nav extends Component
{
    public function render()
    {
        return view('livewire.merchant.aside.nav');
    }
    public function intended($url){
        $this->redirectIntended($url,true);
    }
}
