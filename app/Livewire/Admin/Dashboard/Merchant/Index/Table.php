<?php

namespace App\Livewire\Admin\Dashboard\Merchant\Index;

use App\Models\User;
use Livewire\Component;

class Table extends Component
{
    // public $merchants;
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    public function acceptMerchant($merchantId)
    {
        $merchant = User::find($merchantId);
        if ($merchant) {
            $merchant->update(['status' => 'active']);
            $this->dispatch('notify', ['type' => 'success', 'message' => 'Merchant accepted successfully.']);
        } else {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Merchant not found.']);
        }
    }
    public function rejectMerchant($merchantId)
    {
        $merchant = User::find($merchantId);
        if ($merchant) {
            $merchant->update(['status' => 'rejected']);
            $this->dispatch('notify', ['type' => 'success', 'message' => 'Merchant rejected successfully.']);
        } else {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Merchant not found.']);
        }
    }

    public function render()
    {
        return view('livewire.admin.dashboard.merchant.index.table',[
            'merchants' => User::where('role', 'merchant')
                ->when($this->search, function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                })
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(30),
        ]);
    }
}
