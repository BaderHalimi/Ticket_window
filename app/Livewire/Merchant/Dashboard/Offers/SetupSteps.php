<?php



namespace App\Livewire\Merchant\Dashboard\Offers;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Offering;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Constraint\Count;

class SetupSteps extends Component
{

    public Offering $offering;
    public int $currentStep = 1;
    public $merchantid = null , $finalID = null;

    public function mount(Offering $offering, $merchantid = null,$finalID = null,$currentStep = 1)
    {
        $this->merchantid = $merchantid;
        $this->finalID = $finalID;
        $this->currentStep = $currentStep;
        $this->offering = $offering;
    }


    public function setStep($step)
    {
        $this->currentStep = $step;
        if($this->merchantid != null){
            $this->redirectIntended(route('merchant.dashboard.m.offer.edit',['merchant'=>$this->merchantid,'offer'=>$this->offering->id,'currentStep'=>$this->currentStep]),true);
        }else{
                        $this->redirectIntended(route('merchant.dashboard.offer.edit',['offer'=>$this->offering->id,'currentStep'=>$this->currentStep]),true);
        }
    }
    public function render()
    {


        //dd($isReady = hasEssentialFields($this->offering->id));

        //dd($all_fileds, $true_fileds,$persent_progress);
        //dd($isPublished, $isReady);
        //dd(hasEssentialFields($this->offering->id)['fields']);
        //$d = fetch_time($this->offering->id);
        //dd($d);
        return view('livewire.merchant.dashboard.offers.setup-steps');
    }
}
