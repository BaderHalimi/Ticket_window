<?php



namespace App\Livewire\Merchant\Dashboard\Offers;

use Livewire\Component;
use App\Models\Offering;
use Illuminate\Support\Facades\Auth;
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
    public function publish(){
        //dd('Publishing the offer...');
        $isReady = hasEssentialFields($this->offering->id);
        //dd($isReady);
        if ($isReady) {
            $offering = $this->offering;
            $data = $offering->additional_data;
            $data['is_published'] = true;
            $offering->additional_data = $data;
            $offering->save();
            
            notifcate(Auth::id(), 'success','Offer published successfully!',[
                'title' => 'Offer Published',
                'text' => 'Your offer has been published successfully.',
            ]);
        }

    }
    public function render()
    {
        
        $off = $this->offering->fresh();
        $isPublished = $off->additional_data['is_published'];
        $isReady = true;
        if (!$isPublished) {
            $isReady = hasEssentialFields($this->offering->id)['status'];

        }
        //dd($isPublished, $isReady);
        //dd($isReady);

        return view('livewire.merchant.dashboard.offers.setup-steps',compact('isReady', 'isPublished'));
    
    }
}
