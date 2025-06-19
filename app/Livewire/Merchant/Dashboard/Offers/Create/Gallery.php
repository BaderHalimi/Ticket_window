<?php



namespace App\Livewire\Merchant\Dashboard\Offers\Create;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Offering;
use Illuminate\Support\Facades\Storage;

class Gallery extends Component
{
    use WithFileUploads;

    public Offering $offering;
    public $image;
    public $gallery = [];

    public function mount(Offering $offering)
    {
        $this->offering = $offering;
        $this->gallery = $offering->features['gallery'] ?? [];
    }

    public function updatedImage()
    {
        $path = $this->image->store('offerings', 'public');
        $this->offering->update(['image' => $path]);
        $this->dispatch('image-uploaded');
    }

    public function updatedGallery($files)
    {
        foreach ($files as $file) {
            $path = $file->store('offerings/gallery', 'public');
            $this->gallery[] = $path;
        }

        $this->offering->update([
            'features' => array_merge($this->offering->features ?? [], [
                'gallery' => $this->gallery
            ])
        ]);

        $this->dispatch('gallery-updated');
    }

    public function removeGalleryImage($index)
    {
        unset($this->gallery[$index]);
        $this->gallery = array_values($this->gallery);

        $this->offering->update([
            'features' => array_merge($this->offering->features ?? [], [
                'gallery' => $this->gallery
            ])
        ]);
    }

    public function render()
    {
        return view('livewire.merchant.dashboard.offers.create.gallery');
    }
}
