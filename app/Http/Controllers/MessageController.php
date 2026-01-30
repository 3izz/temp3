<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function show(User $user): View
    {
        abort_if(auth()->id() === $user->id, 404);

        // Enforce role-based chat: user ↔ coach only
        $authUser = auth()->user();
        abort_if(
            !(
                ($authUser->role === 'user' && $user->role === 'coach') ||
                ($authUser->role === 'coach' && $user->role === 'user')
            ),
            403,
            'You can only chat with the opposite role (user ↔ coach).'
        );

        return view('chat.show', [
            'otherUser' => $user,
        ]);
    }

    public function getMessages(User $user): JsonResponse
    {
        $authId = (int) auth()->id();

        // Enforce role-based chat
        $authUser = auth()->user();
        abort_if(
            !(
                ($authUser->role === 'user' && $user->role === 'coach') ||
                ($authUser->role === 'coach' && $user->role === 'user')
            ),
            403
        );

        $messages = Message::query()
            ->with('sender')
            ->where(function ($q) use ($authId, $user) {
                $q->where('sender_id', $authId)->where('receiver_id', $user->id);
            })
            ->orWhere(function ($q) use ($authId, $user) {
                $q->where('sender_id', $user->id)->where('receiver_id', $authId);
            })
            ->orderBy('created_at')
            ->get(['id', 'sender_id', 'receiver_id', 'message', 'created_at']);

        // Format messages to match broadcast format
        $formattedMessages = $messages->map(function ($message) {
            return [
                'id' => $message->id,
                'sender_id' => $message->sender_id,
                'receiver_id' => $message->receiver_id,
                'message' => $message->message,
                'created_at' => $message->created_at->toISOString(),
                'sender' => [
                    'id' => $message->sender->id,
                    'name' => $message->sender->name,
                    'role' => $message->sender->role,
                ],
            ];
        });

        return response()->json([
            'messages' => $formattedMessages,
        ]);
    }

    public function sendMessage(Request $request, User $user): JsonResponse
    {
        $authId = (int) auth()->id();

        abort_if($authId === $user->id, 404);

        // Enforce role-based chat
        $authUser = auth()->user();
        abort_if(
            !(
                ($authUser->role === 'user' && $user->role === 'coach') ||
                ($authUser->role === 'coach' && $user->role === 'user')
            ),
            403
        );

        $validated = $request->validate([
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $message = Message::create([
            'sender_id' => $authId,
            'receiver_id' => $user->id,
            'message' => $validated['message'],
        ]);

        // Load sender relationship for broadcasting
        $message->load('sender');

        // Broadcast the message
        broadcast(new MessageSent($message));

        return response()->json([
            'message' => [
                'id' => $message->id,
                'sender_id' => $message->sender_id,
                'receiver_id' => $message->receiver_id,
                'message' => $message->message,
                'created_at' => $message->created_at->toISOString(),
                'sender' => [
                    'id' => $message->sender->id,
                    'name' => $message->sender->name,
                    'role' => $message->sender->role,
                ],
            ],
        ]);
    }
}
