<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\MerchantChat;
use App\Models\MerchantMessage as MerchantChatMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ChatCenter extends Component
{
    use WithFileUploads;

    public $chat_id;
    public $newMessage = '';
    public $attachment;

    protected $rules = [
        'newMessage' => 'nullable|string|max:1000',
        'attachment' => 'nullable|file|max:10240',
    ];

    public function send()
    {
        $this->validate();

        $data = [
            'merchant_chat_id' => $this->chat_id,
            'user_id' => Auth::id(),
            'message' => $this->newMessage,
            'type' => 'text',
        ];

        if ($this->attachment) {
            $path = $this->attachment->store('chat_attachments', 'public');
            $mime = $this->attachment->getMimeType();
            $filename = $this->attachment->getClientOriginalName();

            $data['type'] = str_starts_with($mime, 'image') ? 'image' : 'file';
            $data['additional_data'] = [
                'path' => $path,
                'name' => $filename,
            ];
        }

        MerchantChatMessage::create($data);
        $this->newMessage = '';
        $this->attachment = null;
    }

    public function deleteMessage($id)
    {
        $msg = MerchantChatMessage::findOrFail($id);
        if ($msg->user_id === Auth::id()) {
            $msg->delete();
        }
    }

    public function render()
    {
        $chats = MerchantChat::with(['messages' => fn($q) => $q->latest()->limit(1), 'user'])
            ->where('merchant_id', Auth::id())
            ->latest()
            ->get();

        $messages = $this->chat_id
            ? MerchantChatMessage::where('merchant_chat_id', $this->chat_id)->with('user')->oldest()->get()
            : [];

        return view('livewire.chat-center', compact('chats', 'messages'));
    }
}
