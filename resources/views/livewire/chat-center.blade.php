<div class="flex">
    <!-- Sidebar with Chats -->
    <div class="w-1/3 border-r p-4">
        <h2 class="font-bold mb-2">Chats</h2>
        <ul>
            @foreach ($chats as $chat)
                <li class="mb-2">
                    <button wire:click="loadChat({{ $chat->id }})" class="text-blue-600">
                        Chat #{{ $chat->id }}
                        <div class="text-sm text-gray-500">
                            {{ $chat->messages->first()->message ?? 'No messages yet' }}
                        </div>
                    </button>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Chat Messages -->
    <div class="w-2/3 p-4">
        @if ($selectedChat)
            <h2 class="font-bold mb-2">Chat #{{ $selectedChat->id }}</h2>
            <div class="border p-2 h-64 overflow-y-scroll mb-2">
                @foreach ($messages as $msg)
                    <div class="mb-1">
                        <span class="font-semibold">{{ $msg->user->name ?? 'User' }}:</span>
                        {{ $msg->message }}
                    </div>
                @endforeach
            </div>

            <form wire:submit.prevent="sendMessage" class="flex">
                <input type="text" wire:model="newMessage" class="flex-1 border p-2" placeholder="Type message..." />
                <button type="submit" class="bg-blue-500 text-white px-4">Send</button>
            </form>
        @else
            <div>Select a chat to view messages.</div>
        @endif
    </div>
</div>
