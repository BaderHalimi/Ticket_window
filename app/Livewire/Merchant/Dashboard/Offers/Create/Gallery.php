<?php

namespace App\Livewire\Merchant\Dashboard\Offers\Create;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Offering;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class Gallery extends Component
{
    use WithFileUploads;

    public Offering $offering;
    public $image;
    public $gallery = [];
    public $gallery1 = [];

    // Configuration
    public $maxGalleryImages = 10;
    public $maxImageSize = 5120; // 5MB in KB
    public $maxGalleryImageSize = 3072; // 3MB in KB
    public $allowedImageTypes = ['jpeg', 'jpg', 'png', 'webp'];

    protected $rules = [
        'image' => [
            'nullable',
            'image',
            'max:5120', // 5MB
            'mimes:jpeg,jpg,png,webp',
            'dimensions:min_width=200,min_height=200,max_width=4000,max_height=4000'
        ],
        'gallery1.*' => [
            'nullable',
            'image',
            'max:3072', // 3MB
            'mimes:jpeg,jpg,png,webp',
            'dimensions:min_width=200,min_height=200,max_width=4000,max_height=4000'
        ]
    ];

    public function mount(Offering $offering)
    {
        try {
            $this->offering = $offering;
            $this->gallery = $offering->features['gallery'] ?? [];
        } catch (\Exception $e) {
            Log::error('Gallery component mount error: ' . $e->getMessage());
            $this->gallery = [];
        }
    }

    /**
     * Custom validation messages
     */
    protected function messages()
    {
        return [
            'image.image' => __('Main image must be a valid image file'),
            'image.max' => __('Main image size cannot exceed 5MB'),
            'image.mimes' => __('Main image must be JPEG, JPG, PNG, or WebP format'),
            'image.dimensions' => __('Main image dimensions must be between 200x200 and 4000x4000 pixels'),

            'gallery1.*.image' => __('Gallery images must be valid image files'),
            'gallery1.*.max' => __('Gallery image size cannot exceed 3MB'),
            'gallery1.*.mimes' => __('Gallery images must be JPEG, JPG, PNG, or WebP format'),
            'gallery1.*.dimensions' => __('Gallery image dimensions must be between 200x200 and 4000x4000 pixels')
        ];
    }

    public function updatedImage()
    {
        try {
            // Validate the main image
            $this->validateOnly('image');

            if ($this->image) {
                // Additional security checks
                if (!$this->isValidImageFile($this->image)) {
                    $this->addError('image', __('Invalid image file format or corrupted file'));
                    return;
                }

                // Store the image
                $path = $this->image->store('offerings', 'public');

                // Update the offering
                $this->offering->update(['image' => $path, 'status' => 'inactive']);

                // Dispatch events
                $this->dispatch('image-uploaded');
                $this->dispatch('ServiceUpdated');
                $this->dispatch('gallery-success', [
                    'message' => __('Main image uploaded successfully')
                ]);

                // Reset the input
                $this->reset('image');
            }
        } catch (\Exception $e) {
            Log::error('Main image upload error: ' . $e->getMessage());
            $this->addError('image', __('Failed to upload image. Please try again.'));

            $this->dispatch('gallery-error', [
                'message' => __('Failed to upload image. Please try again.')
            ]);
        }
    }
    public function updatedGallery1($files)
    {
        try {
            // Validate gallery images
            $this->validateOnly('gallery1.*');

            // Check maximum gallery limit
            if (count($this->gallery) + count($files) > $this->maxGalleryImages) {
                $this->addError('gallery1', __('Cannot add more images. Maximum :max images allowed.', ['max' => $this->maxGalleryImages]));
                return;
            }

            $uploadedCount = 0;
            $errors = [];

            foreach ($files as $file) {
                try {
                    // Additional security checks
                    if (!$this->isValidImageFile($file)) {
                        $errors[] = __('Invalid image file format or corrupted file: :filename', ['filename' => $file->getClientOriginalName()]);
                        continue;
                    }

                    // Store the image
                    $path = $file->store('offerings/gallery', 'public');
                    $this->gallery[] = $path;
                    $uploadedCount++;

                } catch (\Exception $e) {
                    Log::error('Gallery image upload error: ' . $e->getMessage());
                    $errors[] = __('Failed to upload: :filename', ['filename' => $file->getClientOriginalName()]);
                }
            }

            // Update the offering
            $features = $this->offering->features ?? [];
            $features['gallery'] = $this->gallery;
            $this->offering->update(['features' => $features, 'status' => 'inactive']);

            // Dispatch events
            $this->dispatch('gallery-updated');
            $this->dispatch('ServiceUpdated');

            if ($uploadedCount > 0) {
                $this->dispatch('gallery-success', [
                    'message' => __(':count images uploaded successfully', ['count' => $uploadedCount])
                ]);
            }

            // Show errors if any
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    $this->addError('gallery1', $error);
                }
            }

            // Reset the input
            $this->reset('gallery1');

        } catch (\Exception $e) {
            Log::error('Gallery upload error: ' . $e->getMessage());
            $this->addError('gallery1', __('Failed to upload images. Please try again.'));

            $this->dispatch('gallery-error', [
                'message' => __('Failed to upload images. Please try again.')
            ]);
        }
    }

    /**
     * Validate image file security
     */
    private function isValidImageFile($file)
    {
        try {
            // Check if file exists and is readable
            if (!$file || !$file->isValid()) {
                return false;
            }

            // Check file extension
            $extension = strtolower($file->getClientOriginalExtension());
            if (!in_array($extension, $this->allowedImageTypes)) {
                return false;
            }

            // Check MIME type
            $mimeType = $file->getMimeType();
            $allowedMimes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
            if (!in_array($mimeType, $allowedMimes)) {
                return false;
            }

            // Check if it's actually an image by trying to get image info
            $imageInfo = @getimagesize($file->getRealPath());
            if ($imageInfo === false) {
                return false;
            }

            // Check image dimensions
            $width = $imageInfo[0];
            $height = $imageInfo[1];

            if ($width < 200 || $height < 200 || $width > 4000 || $height > 4000) {
                return false;
            }

            return true;

        } catch (\Exception $e) {
            Log::error('Image validation error: ' . $e->getMessage());
            return false;
        }
    }

    public function removeGalleryImage($index)
    {
        try {
            // Validate index to prevent array manipulation attacks
            if (!is_numeric($index) || $index < 0 || $index >= count($this->gallery)) {
                $this->addError('gallery', __('Invalid image index'));
                return;
            }

            $index = (int) $index;

            if (isset($this->gallery[$index])) {
                // Get image path
                $imagePath = $this->gallery[$index];
                if (is_array($imagePath)) {
                    $imagePath = $imagePath['path'] ?? '';
                }

                // Delete file from storage
                if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }

                // Remove from array
                unset($this->gallery[$index]);
                $this->gallery = array_values($this->gallery); // Re-index array

                // Update database
                $features = $this->offering->features ?? [];
                $features['gallery'] = $this->gallery;
                $this->offering->update(['features' => $features, 'status' => 'inactive']);

                // Dispatch events
                $this->dispatch('ServiceUpdated');
                $this->dispatch('gallery-success', [
                    'message' => __('Image removed successfully')
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Gallery image removal error: ' . $e->getMessage());
            $this->addError('gallery', __('Failed to remove image. Please try again.'));

            $this->dispatch('gallery-error', [
                'message' => __('Failed to remove image. Please try again.')
            ]);
        }
    }

    public function render()
    {
        return view('livewire.merchant.dashboard.offers.create.gallery');
    }
}
