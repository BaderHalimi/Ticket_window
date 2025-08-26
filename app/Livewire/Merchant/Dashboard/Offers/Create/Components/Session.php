<?php

namespace App\Livewire\Merchant\Dashboard\Offers\Create\Components;

use Livewire\Component;
use App\Models\Offering;

class Session extends Component
{
    public Offering $offering;

    public $sessions = [];
    public $editingIndex = null;
    public $isLoading = false;
    public $showCreateModal = false;
    public $showEditModal = false;

    // بيانات نموذج الإنشاء
    public $newSession = [
        'speaker' => '',
        'time' => '',
        'description' => ''
    ];

    // بيانات نموذج التعديل
    public $editSession = [
        'speaker' => '',
        'time' => '',
        'description' => ''
    ];

    public function mount(Offering $offering)
    {
        $this->offering = $offering;
        $this->sessions = $this->offering->features['sessions'] ?? [];
    }



    public function openCreateModal()
    {
        $this->showCreateModal = true;
        $this->resetNewSession();
    }

    public function openEditModal($index)
    {
        $this->editingIndex = $index;
        $this->editSession = $this->sessions[$index];
        $this->showEditModal = true;
    }

    public function createSession()
    {
        $this->isLoading = true;

        try {
            // التحقق من صحة البيانات مع حماية XSS و SQL Injection
            $this->validate([
                'newSession.speaker' => 'required|string|min:2|max:255|regex:/^[\p{L}\p{N}\s\-_.]+$/u',
                'newSession.time' => 'required|date_format:H:i',
                'newSession.description' => 'required|string|min:10|max:1000|regex:/^[\p{L}\p{N}\s\-_.,!?()]+$/u'
            ], [
                'newSession.speaker.required' => __('Speaker name is required'),
                'newSession.speaker.min' => __('Speaker name must be at least 2 characters'),
                'newSession.speaker.max' => __('Speaker name must not exceed 255 characters'),
                'newSession.speaker.regex' => __('Speaker name contains invalid characters'),
                'newSession.time.required' => __('Time is required'),
                'newSession.time.date_format' => __('Please enter a valid time format'),
                'newSession.description.required' => __('Description is required'),
                'newSession.description.min' => __('Description must be at least 10 characters'),
                'newSession.description.max' => __('Description must not exceed 1000 characters'),
                'newSession.description.regex' => __('Description contains invalid characters')
            ]);

            // إضافة الجلسة الجديدة مع حماية XSS
            $this->sessions[] = [
                'speaker' => sanitizeInput(trim($this->newSession['speaker'])),
                'time' => $this->newSession['time'],
                'description' => sanitizeInput(trim($this->newSession['description']))
            ];

            // حفظ مباشرة في قاعدة البيانات
            $this->saveToDatabase();

            // إعادة تعيين النموذج وإغلاق المودال
            $this->resetNewSession();
            $this->showCreateModal = false;

            session()->flash('success', __('Session created successfully.'));

        } catch (\Exception $e) {
            session()->flash('error', __('Error creating session: ') . $e->getMessage());
        } finally {
            $this->isLoading = false;
        }
    }

    public function updateSession()
    {
        $this->isLoading = true;

        try {
            // التحقق من صحة البيانات مع حماية XSS و SQL Injection
            $this->validate([
                'editSession.speaker' => 'required|string|min:2|max:255|regex:/^[\p{L}\p{N}\s\-_.]+$/u',
                'editSession.time' => 'required|date_format:H:i',
                'editSession.description' => 'required|string|min:10|max:1000|regex:/^[\p{L}\p{N}\s\-_.,!?()]+$/u'
            ], [
                'editSession.speaker.required' => __('Speaker name is required'),
                'editSession.speaker.min' => __('Speaker name must be at least 2 characters'),
                'editSession.speaker.max' => __('Speaker name must not exceed 255 characters'),
                'editSession.speaker.regex' => __('Speaker name contains invalid characters'),
                'editSession.time.required' => __('Time is required'),
                'editSession.time.date_format' => __('Please enter a valid time format'),
                'editSession.description.required' => __('Description is required'),
                'editSession.description.min' => __('Description must be at least 10 characters'),
                'editSession.description.max' => __('Description must not exceed 1000 characters'),
                'editSession.description.regex' => __('Description contains invalid characters')
            ]);

            // تحديث الجلسة مع حماية XSS
            $this->sessions[$this->editingIndex] = [
                'speaker' => sanitizeInput(trim($this->editSession['speaker'])),
                'time' => $this->editSession['time'],
                'description' => sanitizeInput(trim($this->editSession['description']))
            ];

            // حفظ مباشرة في قاعدة البيانات
            $this->saveToDatabase();

            // إغلاق المودال
            $this->resetEditSession();
            $this->showEditModal = false;

            session()->flash('success', __('Session updated successfully.'));

        } catch (\Exception $e) {
            session()->flash('error', __('Error updating session: ') . $e->getMessage());
        } finally {
            $this->isLoading = false;
        }
    }

    /**
     * حفظ الجلسات في قاعدة البيانات
     */
    private function saveToDatabase()
    {
        $features = $this->offering->features ?? [];

        if (!is_array($features)) {
            $features = json_decode($features, true) ?? [];
        }

        $features['sessions'] = $this->sessions;
        $this->offering->features = $features;
        $this->offering->save();
    }

    public function resetNewSession()
    {
        $this->newSession = ['speaker' => '', 'time' => '', 'description' => ''];
    }

    public function resetEditSession()
    {
        $this->editSession = ['speaker' => '', 'time' => '', 'description' => ''];
        $this->editingIndex = null;
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
        $this->resetNewSession();
    }



    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->resetEditSession();
    }

    public function removeSession($index)
    {
        unset($this->sessions[$index]);
        $this->sessions = array_values($this->sessions);

        // حفظ مباشرة في قاعدة البيانات بعد الحذف
        $this->saveToDatabase();

        session()->flash('success', __('Session deleted successfully.'));
    }
    public function render()
    {
        return view('livewire.merchant.dashboard.offers.create.components.session');
    }
}
