<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // عرض صفحة المحادثة
    public function show(string $id)
    {
        $chat = SupportTicket::findOrFail($id);

        return view('visitor.dashboard.support_chat.chat', compact('chat'));
    }

    // حفظ رسالة جديدة
    public function store(Request $request, string $id)
    {
        $chat = SupportTicket::findOrFail($id);

        $validated = $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        Message::create([
            'user_id' => Auth::id(),
            'message' => $validated['message'],
            'ticket_id' => $chat->id,
        ]);

        return redirect()->route('visitor.support_chat.show', $chat->id);
    }

    // جلب الرسائل عبر AJAX
    public function ajaxMessages($id)
    {
        $messages = Message::where('ticket_id', $id)
            ->with(['user', 'staff'])
            ->orderBy('created_at', 'asc')
            ->get();

        $data = $messages->map(function ($msg) {
            $sender = $msg->user_id ? $msg->user : $msg->staff;

            return [
                'message' => $msg->message,
                'user_id' => $msg->user_id,
                'staff_id' => $msg->staff_id,
                'sender_name' => $sender->name ?? 'غير معروف',
                'sender_image' => $sender->additional_data['image'] ?? null,
                'created_at' => $msg->created_at->diffForHumans(),
            ];
        });

        return response()->json($data);
    }
}
