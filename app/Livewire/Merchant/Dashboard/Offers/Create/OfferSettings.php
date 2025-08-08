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

    public $products = [];
    public $games = [];
    public $activities = [];
    public $editingIndex = null;
    public $sponsorEditingIndex = null;
    public $SpeakereditingIndex = null;
    public $activityeditingIndex = null;
    public $productsEditingIndex = null;
    public $gamesEditingIndex = null;
    public $cartoons = [];
    public $cartoonEditingIndex = null;

    public $workshops = [];
    public $workshopEditingIndex = null;





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
        if (isset($this->offering->features['products'])) {
            $this->products = $this->offering->features['products'];
        } else {
            $this->products = [
                [
                    'name' => '',
                    'image' => '',
                    'price' => '',
                    'description' => '',
                    'category' => '',
                    'link' => '',
                    'booth' => ''
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
        if (isset($this->offering->features['games'])) {
            $this->games = $this->offering->features['games'];
        } else {
            $this->games = [
                [
                    'name' => '',
                    'description' => '',
                    'age_range' => '',
                    'image' => '',
                    'location' => '',
                    'supervisor' => '',
                    'rules' => '',
                ]
            ];
        }

        if (isset($this->offering->features['workshops'])) {
            $this->workshops = $this->offering->features['workshops'];
        } else {
            $this->workshops = [
                [
                    'title' => '',
                    'description' => '',
                    'image' => '',
                ]
            ];
        }
        if (isset($this->offering->features['cartoons'])) {
            $this->cartoons = $this->offering->features['cartoons'];
        } else {
            $this->cartoons = [
                [
                    'name' => '',
                    'description' => '',
                    'image' => '',
                ]
            ];
        }
    }
    
    public function addCartoon()
    {
        $this->cartoons[] = [
            'name' => '',
            'description' => '',
            'image' => '',
        ];
    }

    public function editCartoon($index)
    {
        $this->cartoonEditingIndex = $index;
    }

    public function saveCartoon($index)
    {
        if (isset($this->cartoons[$index]['image']) && is_object($this->cartoons[$index]['image'])) {
            $path = $this->cartoons[$index]['image']->store('cartoons', 'public');
            $this->cartoons[$index]['image'] = $path;
        }

        $this->cartoonEditingIndex = null;
    }

    public function removeCartoon($index)
    {
        array_splice($this->cartoons, $index, 1);
        if ($this->cartoonEditingIndex === $index) {
            $this->cartoonEditingIndex = null;
        }
    }

    public function saveCartoons()
    {
        $cartoons = $this->cartoons;

        // حفظ الصور إن وجدت (تأكدت من ذلك داخل saveCartoon أيضاً)
        foreach ($cartoons as $i => $cartoon) {
            if (isset($cartoon['image']) && is_object($cartoon['image'])) {
                $path = $cartoon['image']->store('cartoons', 'public');
                $cartoons[$i]['image'] = $path;
            }
        }

        $this->offering->features = array_merge(
            $this->offering->features ?? [],
            ['cartoons' => $cartoons]
        );
        $this->offering->save();

        session()->flash('success', 'تم حفظ الشخصيات الكرتونية بنجاح');
    }
    public function addWorkshop()
    {
        $this->workshops[] = [
            'title' => '',
            'description' => '',
            'image' => '',
        ];
    }

    public function editWorkshop($index)
    {
        $this->workshopEditingIndex = $index;
    }

    public function saveWorkshop($index)
    {
        if (isset($this->workshops[$index]['image']) && is_object($this->workshops[$index]['image'])) {
            $path = $this->workshops[$index]['image']->store('workshops', 'public');
            $this->workshops[$index]['image'] = $path;
        }

        $this->workshopEditingIndex = null;
    }

    public function removeWorkshop($index)
    {
        array_splice($this->workshops, $index, 1);
        if ($this->workshopEditingIndex === $index) {
            $this->workshopEditingIndex = null;
        }
    }

    public function saveWorkshops()
    {
        $workshops = $this->workshops;

        foreach ($workshops as $i => $workshop) {
            if (isset($workshop['image']) && is_object($workshop['image'])) {
                $path = $workshop['image']->store('workshops', 'public');
                $workshops[$i]['image'] = $path;
            }
        }

        $this->offering->features = array_merge(
            $this->offering->features ?? [],
            ['workshops' => $workshops]
        );
        $this->offering->save();

        session()->flash('success', 'تم حفظ الورش بنجاح');
    }
    public function addGame()
    {
        $this->games[] = [
            'name' => '',
            'description' => '',
            'age_range' => '',
            'image' => '',
            'location' => '',
            'supervisor' => '',
            'rules' => '',
        ];
        $this->gamesEditingIndex = count($this->games) - 1;
    }
    
    public function editGame($index)
    {
        $this->gamesEditingIndex = $index;
    }
    
    public function saveGame($index)
    {
        $this->gamesEditingIndex = null;
    }
    
    public function removeGame($index)
    {
        array_splice($this->games, $index, 1);
    
        if ($this->gamesEditingIndex === $index) {
            $this->gamesEditingIndex = null;
        } elseif ($this->gamesEditingIndex > $index) {
            $this->gamesEditingIndex--;
        }
    }
    public function saveGames()
{
    foreach ($this->games as $i => $game) {
        if (isset($game['image']) && is_object($game['image'])) {
            $path = $game['image']->store('games', 'public');
            $this->games[$i]['image'] = $path;
        }
    }

    $this->offering->features = array_merge(
        $this->offering->features ?? [],
        ['games' => $this->games]
    );
    $this->offering->save();

    session()->flash('success', 'تم حفظ الألعاب بنجاح');
}
    public function addProduct()
    {
        $this->products[] = 
            [
                'name' => '',
                'image' => '',
                'price' => '',
                'description' => '',
                'category' => '',
                'link' => '',
                'booth' => ''
            ];
        
    }
    public function editProduct($index)
    {
        $this->productsEditingIndex = $index;
    }

    public function saveProduct($index)
    {
        $this->productsEditingIndex = null;
    }

    public function removeProduct($index)
    {
        unset($this->products[$index]);
        $this->products = array_values($this->products);
    }
    public function saveProducts()
    {
        foreach ($this->products as $i => $product) {
            if (isset($product['image']) && is_object($product['image'])) {
                $path = $product['image']->store('products', 'public');
                $this->products[$i]['image'] = $path;
            }
        }

        //$this->offering->products = $this->products;
        $this->offering->features = array_merge(
            $this->offering->features ?? [],
            ['products' => $this->products]
        );
        $this->offering->save();

        session()->flash('success', 'تم حفظ المنتجات بنجاح');
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
