<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\MerchantChat;
use Illuminate\Support\Facades\Auth;

class ChatCenter extends Component
{
    public $chats = [];
    public $selectedChat = null;
    public $messages = [];
    public $newMessage = '';

    public function mount()
    {
        $this->loadChats();
    }

    public function loadChats()
    {
        $this->chats = MerchantChat::with(['messages' => function ($query) {
            $query->latest()->take(1);
        }])
        ->where('merchant_id', Auth::id())
        ->latest()
        ->get();
    }

    public function loadChat($chatId)
    {
        $this->selectedChat = MerchantChat::with(['messages.user'])
            ->where('merchant_id', Auth::id())
            ->findOrFail($chatId);

        $this->messages = $this->selectedChat->messages()
            ->with('user')
            ->orderBy('created_at')
            ->get();
    }

    public function sendMessage()
    {
        $this->validate([
            'newMessage' => 'required|string|max:1000',
        ]);

        if (!$this->selectedChat) {
            session()->flash('error', 'No chat selected.');
            return;
        }

        $message = $this->selectedChat->messages()->create([
            'user_id' => Auth::id(),
            'message' => $this->newMessage,
        ]);

        $this->messages->push($message);
        $this->newMessage = '';

        $this->loadChats(); // refresh latest messages
    }

    public function render()
    {
        return view('livewire.chat-center');
    }
}
