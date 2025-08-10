<?php

namespace App\Livewire\Merchant\Dashboard\Offers\Create;

use Livewire\Component;
use App\Models\Offering;
use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;

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

    public $Portfolio = null;
    public $portfolioEditingIndex = null;

    public $supportedDevices = null;
    public $supportedDevicesEditingIndex = null;

    public $availableTools = null;
    public $availableToolsEditingIndex = null;
    public $Offerfeatures = null;
    public $OfferfeaturesEditingIndex = null;

    public $Destenations = null;
    public $DestenationsEditingIndex = null;

    public $plats = null;
    public $platsEditingIndex = null;
    public function validateAllUploadedImages()
    {
        $fieldsToCheck = [
            'sessions', 'sponsors', 'speakers', 'products', 'games', 'activities', 'services',
            'requirements', 'cartoons', 'workshops', 'links', 'trainingWorkshops', 'Portfolio',
            'supportedDevices', 'availableTools', 'Offerfeatures', 'Destenations', 'plats',
        ];
    
        $rules = [];
    
        foreach ($fieldsToCheck as $field) {
            $value = $this->$field;
    
            if (is_array($value)) {
                foreach ($value as $key => $item) {
                    if ($item instanceof \Illuminate\Http\UploadedFile) {
                        $rules["$field.$key"] = 'image|mimes:jpeg,png,jpg,gif,bmp,webp|max:2048';
                    }
                }
            } else {
                if ($value instanceof \Illuminate\Http\UploadedFile) {
                    $rules[$field] = 'image|mimes:jpeg,png,jpg,gif,bmp,webp|max:2048';
                }
            }
        }
    
        if (!empty($rules)) {
            $this->validate($rules);
        }
    }
    

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
        if ($this->type == "services"){
            
            if (isset($this->offering->features['Portfolio'])) {
                $this->Portfolio = $this->offering->features['Portfolio'];
            } else {
                $this->Portfolio = [
                    [
                        'title' => '',          
                        'description' => '',    
                        'link' => '',           
                        'image' => '',           
                        'date' => '',            
                        'tools' => '',       
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
            if (isset($this->offering->features['supportedDevices'])) {
                $this->supportedDevices = $this->offering->features['supportedDevices'];
            } else {
                $this->supportedDevices = [
                    [
                        'device_name' => '',
                        'model' => '',
                        'description' => '',
                        'image' => null,
                    ]
                ];
            }
            if (isset($this->offering->features['availableTools'])) {
                $this->availableTools = $this->offering->features['availableTools'];
            } else {
                $this->availableTools = [
                    [
                        'name' => '',          
                        'category' => '',      
                        'description' => '',   
                        'model' => '',         
                        'image' => '',         
                        'availability' => '',  
                        'features' => '',     
                
                    ]
                ];
            }
            if (isset($this->offering->features['Destenations'])) {
                $this->Destenations = $this->offering->features['Destenations'];
            } else {
                $this->Destenations = [
                    [
                        'name' => '',
                        'description' => '',
                        'image' => null,     
                
                    ]
                ];
            }
            if (isset($this->offering->features['plats'])) {
                $this->plats = $this->offering->features['plats'];
            } else {
                $this->plats = [
                    [
                        'name' => '',
                        'description' => '',
                        'image' => null,
                        'price' => '',  
                
                    ]
                ];
            }
        }
        if (isset($this->offering->features['Offerfeatures'])) {
            $this->Offerfeatures = $this->offering->features['Offerfeatures'];
        } else {
            $this->Offerfeatures = [
                [
                    'name' => '',
                    'description' => '',
                    'image' => null,
            
                ]
            ];
        }

    }
    public function addPlat()
    {
        $this->plats[] = [
            'name' => '',
            'description' => '',
            'image' => null,
            'price' => '',
        ];
        $this->platsEditingIndex = count($this->plats) - 1;
    }

    public function editPlat($index)
    {
        $this->platsEditingIndex = $index;
    }

    public function savePlat($index)
    {
        $this->platsEditingIndex = null;
    }

    public function removePlat($index)
    {
        unset($this->plats[$index]);
        $this->plats = array_values($this->plats);

        if ($this->platsEditingIndex === $index) {
            $this->platsEditingIndex = null;
        } elseif ($this->platsEditingIndex > $index) {
            $this->platsEditingIndex--;
        }
    }

    public function savePlats()
    {
        $this->validateAllUploadedImages();

        foreach ($this->plats as $i => $plat) {
            if (isset($plat['image']) && is_object($plat['image'])) {
                $path = $plat['image']->store('plats', 'public');
                $this->plats[$i]['image'] = $path;
            }
        }

        $this->offering->features = array_merge(
            $this->offering->features ?? [],
            ['plats' => $this->plats]
        );

        $this->offering->save();
        

        session()->flash('success', 'تم حفظ الأطباق بنجاح');
    }

    public function addDestination()
    {
        $this->Destenations[] = [
            'name' => '',
            'description' => '',
            'image' => null,
        ];
        $this->DestenationsEditingIndex = count($this->Destenations) - 1;
    }

    public function editDestination($index)
    {
        $this->DestenationsEditingIndex = $index;
    }

    public function saveDestination($index)
    {
        $this->DestenationsEditingIndex = null;
    }

    public function removeDestination($index)
    {
        unset($this->Destenations[$index]);
        $this->Destenations = array_values($this->Destenations);

        if ($this->DestenationsEditingIndex === $index) {
            $this->DestenationsEditingIndex = null;
        } elseif ($this->DestenationsEditingIndex > $index) {
            $this->DestenationsEditingIndex--;
        }
    }

    public function saveDestenations()
    {
        $this->validateAllUploadedImages();

        foreach ($this->Destenations as $i => $destination) {
            if (isset($destination['image']) && is_object($destination['image'])) {
                $path = $destination['image']->store('destenations', 'public');
                $this->Destenations[$i]['image'] = $path;
            }
        }

        $this->offering->features = array_merge(
            $this->offering->features ?? [],
            ['Destenations' => $this->Destenations]
        );

        $this->offering->save();

        session()->flash('success', 'تم حفظ الوجهات السياحية بنجاح');
    }
    public function addOfferFeature()
    {
        $this->Offerfeatures[] = [
            'name' => '',
            'description' => '',
            'image' => null,
        ];
        $this->OfferfeaturesEditingIndex = count($this->Offerfeatures) - 1;
    }

    public function editOfferFeature($index)
    {
        $this->OfferfeaturesEditingIndex = $index;
    }

    public function saveOfferFeature($index)
    {
        $this->OfferfeaturesEditingIndex = null;
    }

    public function removeOfferFeature($index)
    {
        unset($this->Offerfeatures[$index]);
        $this->Offerfeatures = array_values($this->Offerfeatures);

        if ($this->OfferfeaturesEditingIndex === $index) {
            $this->OfferfeaturesEditingIndex = null;
        } elseif ($this->OfferfeaturesEditingIndex > $index) {
            $this->OfferfeaturesEditingIndex--;
        }
    }

    public function saveOfferFeatures()
    {
        $this->validateAllUploadedImages();

        foreach ($this->Offerfeatures as $i => $feature) {
            if (isset($feature['image']) && is_object($feature['image'])) {
                $path = $feature['image']->store('offerfeatures', 'public');
                $this->Offerfeatures[$i]['image'] = $path;
            }
        }

        $this->offering->features = array_merge(
            $this->offering->features ?? [],
            ['Offerfeatures' => $this->Offerfeatures]
        );

        $this->offering->save();

        session()->flash('success', 'تم حفظ مزايا العرض بنجاح');
    }

    public function addAvailableTool()
    {
        $this->availableTools[] = [
            'name' => '',
            'category' => '',
            'description' => '',
            'model' => '',
            'image' => null,
            'availability' => '',
            'features' => '',
        ];
        $this->availableToolsEditingIndex = count($this->availableTools) - 1; 
    }
    public function editAvailableTool($index)
    {
        $this->availableToolsEditingIndex = $index;
    }
    public function saveAvailableTool($index)
    {
        // if (isset($this->availableTools[$index]['image']) && is_object($this->availableTools[$index]['image'])) {
        //     $path = $this->availableTools[$index]['image']->store('available_tools', 'public');
        //     $this->availableTools[$index]['image'] = $path;
        // }
        $this->availableToolsEditingIndex = null;
    }
    public function removeAvailableTool($index)
    {
        unset($this->availableTools[$index]);
        $this->availableTools = array_values($this->availableTools);
    
        if ($this->availableToolsEditingIndex === $index) {
            $this->availableToolsEditingIndex = null;
        } elseif ($this->availableToolsEditingIndex > $index) {
            $this->availableToolsEditingIndex--;
        }
    }
    public function saveAvailableTools()
    {
        $this->validateAllUploadedImages();

        foreach ($this->availableTools as $i => $tool) {
            if (isset($tool['image']) && is_object($tool['image'])) {
                $path = $tool['image']->store('available_tools', 'public');
                $this->availableTools[$i]['image'] = $path;
            }
        }

        $this->offering->features = array_merge(
            $this->offering->features ?? [],
            ['availableTools' => $this->availableTools]
        );
        $this->offering->save();

        session()->flash('success', 'تم حفظ الأدوات المتاحة بنجاح');
    }
    public function addSupportedDevice()
    {
        $this->supportedDevices[] = [
            'device_name' => '',
            'model' => '',
            'description' => '',
            'image' => '',
        ];
        $this->supportedDevicesEditingIndex = count($this->supportedDevices) - 1; 
    }
    
    public function editSupportedDevice($index)
    {
        $this->supportedDevicesEditingIndex = $index;
    }
    
    public function saveSupportedDevice($index)
    {
        $this->supportedDevicesEditingIndex = null;
    }
    
    public function saveSupportedDevices()
    {
        $this->validateAllUploadedImages();

        foreach ($this->supportedDevices as $i => $device) {
            if (isset($device['image']) && is_object($device['image'])) {
                $path = $device['image']->store('supported_devices', 'public');
                $this->supportedDevices[$i]['image'] = $path;
            }
        }
    
        $this->offering->features = array_merge(
            $this->offering->features ?? [],
            ['supportedDevices' => $this->supportedDevices]
        );
        $this->offering->save();
    
        session()->flash('success', 'تم حفظ الأجهزة المدعومة بنجاح');
    }
    
    
    public function removeSupportedDevice($index)
    {
        unset($this->supportedDevices[$index]);
        $this->supportedDevices = array_values($this->supportedDevices);
    
        if ($this->supportedDevicesEditingIndex === $index) {
            $this->supportedDevicesEditingIndex = null;
        } elseif ($this->supportedDevicesEditingIndex > $index) {
            $this->supportedDevicesEditingIndex--;
        }
    }
    

    public function addPortfolio()
    {
        $this->Portfolio[] = [
            'title' => '',
            'description' => '',
            'link' => '',
            'image' => '',
            'date' => '',
            'tools' => '',
        ];
        $this->portfolioEditingIndex = count($this->Portfolio) - 1;
    }
    
    public function editPortfolioRow($index)
    {
        $this->portfolioEditingIndex = $index;
    }
    
    public function savePortfolioRow($index)
    {
        if (isset($this->Portfolio[$index]['image']) && is_object($this->Portfolio[$index]['image'])) {
            $path = $this->Portfolio[$index]['image']->store('portfolio', 'public');
            $this->Portfolio[$index]['image'] = $path;
        }
    
        $this->portfolioEditingIndex = null;
    }
    
    public function removePortfolio($index)
    {
        unset($this->Portfolio[$index]);
        $this->Portfolio = array_values($this->Portfolio);
    
        if ($this->portfolioEditingIndex === $index) {
            $this->portfolioEditingIndex = null;
        } elseif ($this->portfolioEditingIndex > $index) {
            $this->portfolioEditingIndex--;
        }
    }
    
    public function savePortfolio()
    {
        $this->validateAllUploadedImages();

        foreach ($this->Portfolio as $i => $item) {
            if (isset($item['image']) && is_object($item['image'])) {
                $path = $item['image']->store('portfolio', 'public');
                $this->Portfolio[$i]['image'] = $path;
            }
        }
    
        $this->offering->features = array_merge(
            $this->offering->features ?? [],
            ['Portfolio' => $this->Portfolio]
        );
    
        $this->offering->save();
    
        session()->flash('success', 'تم حفظ البورتفوليو بنجاح');
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
        $this->validateAllUploadedImages();

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
        $this->validateAllUploadedImages();

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
        $this->validateAllUploadedImages();

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
        $this->validateAllUploadedImages();

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
        $this->validateAllUploadedImages();

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
        $this->validateAllUploadedImages();

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
        $this->validateAllUploadedImages();

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
        $this->validateAllUploadedImages();

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
        $this->validateAllUploadedImages();

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
        $this->validateAllUploadedImages();

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
