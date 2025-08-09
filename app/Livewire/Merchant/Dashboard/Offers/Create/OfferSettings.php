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
    public $type;

    public $sessions = [];
    public $sponsors = [];
    public $speakers = [];

    public $products = [];
    public $games = [];
    public $activities = [];
    public $services = [];
    public $requirements = [];
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

    public $links = [];
    public $linksEditingIndex = null;
    public $trainingWorkshops = [];
    public $trainingWorkshopsEditingIndex = null;
    public $servicesEditingIndex = null;
    public $requirementsEditingIndex = null;





    public function mount()
    {
        $this->category = $this->offering->category;
        $this->type = $this->offering->type;

        if ($this->type == "events"){
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
            if (isset($this->offering->features['services'])) {
                $this->services = $this->offering->features['services'];
            } else {
                $this->services = [
                    [
                        'title' => '',
                        'description' => '',
                        'time' => '',
                        'location' => '',
                        'image' => '',
                    ]
                ];
            }
            if (isset($this->offering->features['requirements'])) {
                $this->requirements = $this->offering->features['requirements'];
            } else {
                $this->requirements = [
                    [
                        'title' => '',
                        'hint' => '',       
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
            if (isset($this->offering->features['games']) && $this->category =="children_event") {
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
    
            if (isset($this->offering->features['workshops']) && $this->category =="children_event") {
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
            if (isset($this->offering->features['cartoons']) && $this->category =="children_event") {
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
            if (isset($this->offering->features['links']) && $this->category =="online") {
                $this->links = $this->offering->features['links'];
            } else {
                $this->links = [
                    [
                        'platform' => '',
                        'url' => '',
                        'description' => '',
                    ]
                ];
            }
            if (isset($this->offering->features['trainingWorkshops']) && $this->category =="workshop") {
                $this->trainingWorkshops = $this->offering->features['trainingWorkshops'];
            } else {
                $this->trainingWorkshops = [
                    [
                        'title' => '',          
                        'description' => '',            
                        'duration' => '',
                        'location' => '',       
                        'instructor' => '',      
                        'image' => '',         
                        'certificate' => false, 
                    ]
                ];
            }
        }

    }

    public function addTrainingWorkshop()
    {
        $this->trainingWorkshops[] = [
            'title' => '',          
            'description' => '',           
            'duration' => '',       
            'location' => '',      
            'instructor' => '',      
            'image' => '',         
            'certificate' => false, 
        ];
    }
    public function editTrainingWorkshop($index)
    {
        $this->trainingWorkshopsEditingIndex = $index;
    }

    public function saveTrainingWorkshop($index)
    {
        if (isset($this->trainingWorkshops[$index]['image']) && is_object($this->trainingWorkshops[$index]['image'])) {
            $path = $this->trainingWorkshops[$index]['image']->store('workshops', 'public');
            $this->trainingWorkshops[$index]['image'] = $path;
        }

        $this->trainingWorkshopsEditingIndex = null;
    }

    public function removeTrainingWorkshop($index)
    {
        array_splice($this->trainingWorkshops, $index, 1);
        if ($this->trainingWorkshopsEditingIndex === $index) {
            $this->trainingWorkshopsEditingIndex = null;
        } elseif ($this->trainingWorkshopsEditingIndex > $index) {
            $this->trainingWorkshopsEditingIndex--;
        }
    }

    public function saveTrainingWorkshops()
    {
        foreach ($this->trainingWorkshops as $i => $w) {
            if (isset($w['image']) && is_object($w['image'])) {
                $path = $w['image']->store('workshops', 'public');
                $this->trainingWorkshops[$i]['image'] = $path;
            }
        }

        $this->offering->features = array_merge(
            $this->offering->features ?? [],
            ['trainingWorkshops' => $this->trainingWorkshops]
        );

        $this->offering->save();

        session()->flash('success', 'تم حفظ الدورات والورش بنجاح');
    }
    public function addLink()
    {
        $this->links[] = [
            'platform' => '',
            'url' => '',
            'description' => '',
        ];
    }

    public function editLink($index)
    {
        $this->linksEditingIndex = $index;
    }

    public function saveLink($index)
    {
        $this->linksEditingIndex = null;
    }

    public function removeLink($index)
    {
        unset($this->links[$index]);
        $this->links = array_values($this->links);
    }

    public function saveLinks()
    {
        $this->offering->features = array_merge(
            $this->offering->features ?? [],
            ['links' => $this->links]
        );

        $this->offering->save();

        session()->flash('success', 'تم حفظ روابط الفعالية بنجاح');
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
    public function addService()
    {
        $this->services[] = [
            'title' => '',
            'description' => '',
            'time' => '',
            'location' => '',
            'image' => '',
        ];
        
    }
    
    public function editServiceRow($index)
    {
        $this->servicesEditingIndex = $index;
    }

    public function saveServiceRow($index)
    {
        $this->servicesEditingIndex = null;
    }

    public function removeService($index)
    {
        unset($this->services[$index]);
        $this->services = array_values($this->services);
    }

    public function saveServices()
    {
        foreach ($this->services as $i => $activity) {
            if (isset($activity['image']) && is_object($activity['image'])) {
                $path = $activity['image']->store('services', 'public');
                $this->services[$i]['image'] = $path;
            }
        }

        //$this->offering->activities = $this->activities;
        $this->offering->features = array_merge(
            $this->offering->features ?? [],
            ['services' => $this->services]
        );
        $this->offering->save();

        session()->flash('success', 'تم حفظ الفعاليات بنجاح');
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
