<?php

namespace App\Livewire\Merchant\Dashboard\Offers\Create\Components;

use Livewire\Component;
use App\Models\Offering;
use Livewire\WithFileUploads;


class Eventlinks extends Component
{
    use WithFileUploads;

    public Offering $offering;
    public $links = [];
    public $editingIndex = null;
    public $isLoading = false;
    public $showCreateModal = false;
    public $showEditModal = false;

    // بيانات نموذج الإنشاء
    public $newLink = [
        'platform' => '',
        'url' => '',
        'description' => ''
    ];

    // بيانات نموذج التعديل
    public $editLink = [
        'platform' => '',
        'url' => '',
        'description' => ''
    ];


    public function mount(Offering $offering){
        $this->offering = $offering;
        if (isset($this->offering->features['links']) ) {
            $this->links = $this->offering->features['links'];
        } else {
            $this->links = [

            ];
        }

    }

    public function openCreateModal()
    {
        $this->showCreateModal = true;
        $this->resetNewLink();
    }

    public function openEditModal($index)
    {
        $this->editingIndex = $index;
        $this->editLink = $this->links[$index];
        $this->showEditModal = true;
    }

    public function createLink()
    {
        $this->isLoading = true;

        try {
            // التحقق من صحة البيانات مع حماية XSS و SQL Injection
            $this->validate([
                'newLink.platform' => 'required|string|min:2|max:255|regex:/^[\p{L}\p{N}\s\-_.]+$/u',
                'newLink.url' => 'required|url|max:500|regex:/^https?:\/\/.+$/i',
                'newLink.description' => 'required|string|min:10|max:1000|regex:/^[\p{L}\p{N}\s\-_.,!?()]+$/u'
            ], [
                'newLink.platform.required' => __('Platform name is required'),
                'newLink.platform.min' => __('Platform name must be at least 2 characters'),
                'newLink.platform.max' => __('Platform name must not exceed 255 characters'),
                'newLink.platform.regex' => __('Platform name contains invalid characters'),
                'newLink.url.required' => __('URL is required'),
                'newLink.url.url' => __('Please enter a valid URL'),
                'newLink.url.max' => __('URL must not exceed 500 characters'),
                'newLink.url.regex' => __('URL must start with http:// or https://'),
                'newLink.description.required' => __('Description is required'),
                'newLink.description.min' => __('Description must be at least 10 characters'),
                'newLink.description.max' => __('Description must not exceed 1000 characters'),
                'newLink.description.regex' => __('Description contains invalid characters')
            ]);

            // إضافة الرابط الجديد مع حماية XSS
            $this->links[] = [
                'platform' => sanitizeInput(trim($this->newLink['platform'])),
                'url' => filter_var(trim($this->newLink['url']), FILTER_SANITIZE_URL),
                'description' => sanitizeInput(trim($this->newLink['description']))
            ];

            // حفظ مباشرة في قاعدة البيانات
            $this->saveToDatabase();

            // إعادة تعيين النموذج وإغلاق المودال
            $this->resetNewLink();
            $this->showCreateModal = false;

            session()->flash('success', __('Link created successfully.'));

        } catch (\Exception $e) {
            session()->flash('error', __('Error creating link: ') . $e->getMessage());
        } finally {
            $this->isLoading = false;
        }
    }

    public function updateLink()
    {
        $this->isLoading = true;

        try {
            // التحقق من صحة البيانات مع حماية XSS و SQL Injection
            $this->validate([
                'editLink.platform' => 'required|string|min:2|max:255|regex:/^[\p{L}\p{N}\s\-_.]+$/u',
                'editLink.url' => 'required|url|max:500|regex:/^https?:\/\/.+$/i',
                'editLink.description' => 'required|string|min:10|max:1000|regex:/^[\p{L}\p{N}\s\-_.,!?()]+$/u'
            ], [
                'editLink.platform.required' => __('Platform name is required'),
                'editLink.platform.min' => __('Platform name must be at least 2 characters'),
                'editLink.platform.max' => __('Platform name must not exceed 255 characters'),
                'editLink.platform.regex' => __('Platform name contains invalid characters'),
                'editLink.url.required' => __('URL is required'),
                'editLink.url.url' => __('Please enter a valid URL'),
                'editLink.url.max' => __('URL must not exceed 500 characters'),
                'editLink.url.regex' => __('URL must start with http:// or https://'),
                'editLink.description.required' => __('Description is required'),
                'editLink.description.min' => __('Description must be at least 10 characters'),
                'editLink.description.max' => __('Description must not exceed 1000 characters'),
                'editLink.description.regex' => __('Description contains invalid characters')
            ]);

            // تحديث الرابط مع حماية XSS
            $this->links[$this->editingIndex] = [
                'platform' => sanitizeInput(trim($this->editLink['platform'])),
                'url' => filter_var(trim($this->editLink['url']), FILTER_SANITIZE_URL),
                'description' => sanitizeInput(trim($this->editLink['description']))
            ];

            // حفظ مباشرة في قاعدة البيانات
            $this->saveToDatabase();

            // إغلاق المودال
            $this->resetEditLink();
            $this->showEditModal = false;

            session()->flash('success', __('Link updated successfully.'));

        } catch (\Exception $e) {
            session()->flash('error', __('Error updating link: ') . $e->getMessage());
        } finally {
            $this->isLoading = false;
        }
    }

    public function removeLink($index)
    {
        unset($this->links[$index]);
        $this->links = array_values($this->links);

        // حفظ مباشرة في قاعدة البيانات بعد الحذف
        $this->saveToDatabase();

        session()->flash('success', __('Link deleted successfully.'));
    }

    /**
     * حفظ الروابط في قاعدة البيانات
     */
    private function saveToDatabase()
    {
        $features = $this->offering->features ?? [];

        if (!is_array($features)) {
            $features = json_decode($features, true) ?? [];
        }

        $features['links'] = $this->links;
        $this->offering->features = $features;
        $this->offering->save();
    }

    public function resetNewLink()
    {
        $this->newLink = ['platform' => '', 'url' => '', 'description' => ''];
    }

    public function resetEditLink()
    {
        $this->editLink = ['platform' => '', 'url' => '', 'description' => ''];
        $this->editingIndex = null;
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
        $this->resetNewLink();
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->resetEditLink();
    }

    public function render()
    {
        return view('livewire.merchant.dashboard.offers.create.components.eventlinks');
    }
}
