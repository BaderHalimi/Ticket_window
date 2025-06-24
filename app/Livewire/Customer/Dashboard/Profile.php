<?php

namespace App\Livewire\Customer\Dashboard;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class Profile extends Component
{
    use WithFileUploads;

    public $f_name, $l_name, $email, $phone, $password;
    public $image;
    public $notify_email = true;
    public $notify_sms = true;

    public function mount()
    {
        $user = Auth::user();

        $this->f_name = $user->f_name;
        $this->l_name = $user->l_name;
        $this->email = $user->email;
        $this->phone = $user->phone;

        $this->notify_email = $user->additional_data['notify_email'] ?? true;
        $this->notify_sms = $user->additional_data['notify_sms'] ?? true;
    }

    public function updated($field)
    {
        $this->validateOnly($field, [
            'f_name' => 'required|string|max:255',
            'l_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6',
            'image' => 'nullable|image|max:2048',
        ]);

        $this->save();
    }

    public function save()
    {
        $user = Auth::user();
    
        $user->f_name = $this->f_name;
        $user->l_name = $this->l_name;
        $user->phone = $this->phone;
    
        // تعديل إشعارات في additional_data
        $data = $user->additional_data ?? [];
        $data['notify_email'] = $this->notify_email;
        $data['notify_sms'] = $this->notify_sms;
    
        // رفع الصورة وتخزين الرابط في additional_data
        if ($this->image) {
            $path = $this->image->store('profile-photos', 'public');
            $data['profile_image'] = $path;
        }
    
        $user->additional_data = $data;
    
        if (!empty($this->password)) {
            $user->password = bcrypt($this->password);
        }
    
        $user->save();
    }
    

    public function render()
    {
        return view('livewire.customer.dashboard.profile');
    }
}

