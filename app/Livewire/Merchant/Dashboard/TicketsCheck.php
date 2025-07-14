<?php

namespace App\Livewire\Merchant\Dashboard;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\PaidReservation;
use Illuminate\Support\Facades\Auth;

class TicketsCheck extends Component

{
    public $code = '';
    public $reservation = null;
    public $error = null;

    public function check()
    {
        $this->reset(['reservation', 'error']);

        $this->validate([
            'code' => 'required|string'
        ]);

        $res = PaidReservation::where('code', $this->code)->first();

        if ($res) {
            $this->reservation = $res;
        } else {
            $this->error = 'لم يتم العثور على تذكرة بهذا الرقم.';
        }
        set_presence($this->reservation);
    }
    #[On('qr-scanned')]
    public function scanned($decodedText){
        $this->code = $decodedText;
    }


    public function render()
    {
        return view('livewire.merchant.dashboard.tickets-check');
    }
}
