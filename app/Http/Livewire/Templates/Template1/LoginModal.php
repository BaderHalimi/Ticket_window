<?php
namespace App\Http\Livewire\Templates\Template1;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginModal extends Component
{
    public $email = '';
    public $password = '';
    public $error = '';
    public $show = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function login()
    {
        $this->validate();
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            $this->error = '';
            $this->show = false;
            $this->emit('userLoggedIn');
        } else {
            $this->error = __('بيانات الدخول غير صحيحة');
        }
    }

    public function render()
    {
        return view('livewire.templates.template1.login-modal');
    }
}
