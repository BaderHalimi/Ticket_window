<?php



namespace App\Livewire\Merchant\Dashboard\Offers;

use Livewire\Component;
use App\Models\Offering;

class SetupSteps extends Component
{
    public Offering $offering;
    public int $currentStep = 1;

    public function mount(Offering $offering)
    {
        $this->offering = $offering;
    }

    public function setStep($step)
    {
        $this->currentStep = $step;
    }

    public function render()
    {
        return view('livewire.merchant.dashboard.offers.setup-steps');
    }
}
