<?php

namespace App\Livewire\Tepmlates\Template1;

use App\Models\Offering;
use Carbon\Carbon;
use Livewire\Component;

class Item extends Component
{
    public $offer;
    public $merchant;
    public function mount(Offering $offer, $merchant)
    {
        $this->offer = $offer;
        $this->merchant = $merchant;
    }

    public function render()
    {
        return view('livewire.tepmlates.template1.item');
    }
    public function fullView()
    {
        $this->redirectIntended(route('template1.item', ['id' => $this->merchant->id, 'offering' => $this->offer->id]),true);
        // return redirect()->route('merchant.dashboard.offer.edit', $this->offer->id);
    }
}
