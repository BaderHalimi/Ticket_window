<?php

namespace App\Livewire\Merchant\Dashboard\Offers;

use Livewire\Component;

class SetupSteps extends Component
{
    public int $currentStep;

    #[\Livewire\Attributes\On('setStep')]
    public function setStep($step)
    {
        $this->currentStep = $step;
    }
    public function render()
    {
        return view('livewire.merchant.dashboard.offers.setup-steps');
    }
}
