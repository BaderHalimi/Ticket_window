<?php

namespace App\Livewire\Merchant\Dashboard\Offers\Create;

use Livewire\Component;
use App\Models\Offering;
use Livewire\WithFileUploads;

class OfferSettings extends Component
{
    use WithFileUploads;
    public Offering $offering;
    public $category;

    public $sessions = [];
    public $sponsors = [];
    public $speakers = [];
    public $activities = [];
    public $editingIndex = null;
    public $sponsorEditingIndex = null;
    public $SpeakereditingIndex = null;
    public $activityeditingIndex = null;




    public function mount()
    {
        $this->category = $this->offering->category;

        if (isset($this->offering->features['sessions'])) {
            $this->sessions = $this->offering->features['sessions'];
        } else {
            $this->sessions = [
                [
                    'speaker' => '',
                    'date' => '',
                    'time' => '',
                    'location' => '',
                    'description' => '',
                    'image' => ''
                ]
            ];
        }

        if (isset($this->offering->features['speakers'])) {
            $this->speakers = $this->offering->features['speakers'];
        } else {
            $this->speakers = [
                [
                    'name' => '',
                    'title' => '',
                    'cv' => '',
                    'image' => '',
                    'shortDescreption' => '',
                ]
            ];
        }

        if (isset($this->offering->features['activities'])) {
            $this->activities = $this->offering->features['activities'];
        } else {
            $this->activities = [
                [
                    'title' => '',
                    'description' => '',
                    'time' => '',
                    'location' => '',
                    'image' => '',
                ]
            ];
        }
        if (isset($this->offering->features['sponsors'])) {
            $this->sponsors = $this->offering->features['sponsors'];
        } else {
            $this->sponsors = [
                [
                    'name' => '',
                    'level' => '',
                    'logo' => '',
                    'link' => '',
                    'description' => '',
                ]
            ];
        }
    }
    public function addActivity()
    {
        $this->activities[] = [
            'title' => '',
            'description' => '',
            'time' => '',
            'location' => '',
            'image' => '',
        ];
        
    }
    
    public function editActivityRow($index)
    {
        $this->activityeditingIndex = $index;
    }

    public function saveActivityRow($index)
    {
        $this->activityeditingIndex = null;
    }

    public function removeActivity($index)
    {
        unset($this->activities[$index]);
        $this->activities = array_values($this->activities);
    }

    public function saveActivities()
    {
        foreach ($this->activities as $i => $activity) {
            if (isset($activity['image']) && is_object($activity['image'])) {
                $path = $activity['image']->store('activities', 'public');
                $this->activities[$i]['image'] = $path;
            }
        }

        //$this->offering->activities = $this->activities;
        $this->offering->features = array_merge(
            $this->offering->features ?? [],
            ['activities' => $this->activities]
        );
        $this->offering->save();

        session()->flash('success', 'تم حفظ الفعاليات بنجاح');
    }
    public function addSpeaker()
    {
        $this->speakers[] = [
            'name' => '',
            'title' => '',
            'cv' => '',
            'image' => '',
            'shortDescreption' => '',
        ];
        
    }
        public function editSpeaker($index)
    {
        $this->SpeakereditingIndex = $index;
    }

    public function removeSpeaker($index)
    {
        unset($this->speakers[$index]);
        $this->speakers = array_values($this->speakers);
    }

    public function saveSpeaker($index)
    {
        $this->SpeakereditingIndex = null;
    }

    public function saveSpeakers()
    {
        foreach ($this->speakers as $i => $speaker) {
            if (isset($speaker['image']) && is_object($speaker['image'])) {
                $path = $speaker['image']->store('speakers', 'public');
                $this->speakers[$i]['image'] = $path;
            }
        }

        //$this->offering->speakers = $this->speakers;
        $this->offering->features = array_merge(
            $this->offering->features ?? [],
            ['speakers' => $this->speakers]
        );
        $this->offering->save();

        session()->flash('success', 'تم حفظ المتحدثين بنجاح');
    }
    public function addSponsor()
    {
        $this->sponsors[] = [
            'name' => '',
            'level' => '',
            'logo' => '',
            'description' => '',
            'link' => ''
        ];
        $this->sponsorEditingIndex = array_key_last($this->sponsors);
    }

    public function removeSponsor($index)
    {
        unset($this->sponsors[$index]);
        $this->sponsors = array_values($this->sponsors); 
        if ($this->sponsorEditingIndex === $index) {
            $this->sponsorEditingIndex = null;
        }
    }

    public function editSponsorRow($index)
    {
        $this->sponsorEditingIndex = $index;
    }

    public function saveSponsorRow($index)
    {
        $this->sponsorEditingIndex = null;
    }

    public function saveSponsors()
    {
        foreach ($this->sponsors as $i => $sponsor) {
            if (isset($sponsor['logo']) && is_object($sponsor['logo'])) {
                $path = $sponsor['logo']->store('sponsors', 'public');
                $this->sponsors[$i]['logo'] = $path;
            }
        }
    
        $this->offering->features = array_merge(
            $this->offering->features ?? [],
            ['sponsors' => $this->sponsors]
        );
        $this->offering->save();
    
        session()->flash('success', 'تم حفظ الرعاة بنجاح');
    }
    

    public function editRow($index)
    {
        $this->editingIndex = $index;
    }
    
    public function saveRow($index)
    {
        $this->editingIndex = null;
    }
    public function addSession()
    {
        $this->sessions[] = [
            'speaker' => '',
            'date' => '',
            'time' => '',
            'location' => '',
            'description' => '',
            'image' => ''
        ];
    }

    public function removeSession($index)
    {
        unset($this->sessions[$index]);
        $this->sessions = array_values($this->sessions);
    }

    public function saveSessions()
    {
        $features = $this->offering->features ?? [];

        if (!is_array($features)) {
            $features = json_decode($features, true);
        }

        $features['sessions'] = $this->sessions;

        $this->offering->features = $features;
        $this->offering->save();

        session()->flash('success', 'تم حفظ الجلسات بنجاح.');
    }

    public function render()
    {
        return view('livewire.merchant.dashboard.offers.create.offer-settings');
    }
}
