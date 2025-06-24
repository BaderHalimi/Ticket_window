<?php


namespace App\Livewire;

use Livewire\Component;
use App\Models\Support_chat as SupportMessage;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class SupportChat extends Component
{
    use WithPagination;

    public $support_id;
    public $newMessage = '';

    protected $rules = [
        'newMessage' => 'required|string|max:5000',
    ];

    public function deleteMessage($id)
    {
        $message = SupportMessage::findOrFail($id);

        $message->delete();
    
    }
    public function send()
    {
        $this->validate();

        SupportMessage::create([
            'support_id' => $this->support_id,
            'user_id' => Auth::id(),
            'message' => $this->newMessage,
            'type' => 'text',
        ]);

        $this->newMessage = '';
    }

    public function render()
    {
        $messages = SupportMessage::where('support_id', $this->support_id)
            ->orderBy('created_at')
            ->get();

        return view('livewire.support-chat', compact('messages'));
    }
}
