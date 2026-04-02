<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminChat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminChatController extends Controller
{
    /**
     * Ambil pesan chat. Mendukung polling via ?after=<id>.
     */
    public function index(Request $request): JsonResponse
    {
        $query = AdminChat::with(['user:id,name,email', 'replyTo.user:id,name']);

        if ($request->filled('after')) {
            $query->where('id', '>', (int) $request->input('after'));
        } else {
            $query->latest()->limit(50);
        }

        $messages = $query->orderBy('id', 'asc')->get();
        $currentUserId = (int) $request->user()->id;

        return response()->json([
            'messages' => $messages->map(fn (AdminChat $chat) => $this->formatMessage($chat, $currentUserId)),
        ]);
    }

    /**
     * Kirim pesan chat baru (bisa dengan reply).
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'message'     => ['required', 'string', 'max:2000'],
            'reply_to_id' => ['nullable', 'integer', 'exists:admin_chats,id'],
        ]);

        $chat = AdminChat::create([
            'user_id'     => $request->user()->id,
            'reply_to_id' => $request->input('reply_to_id'),
            'message'     => trim($request->input('message')),
        ]);

        $chat->load(['user:id,name,email', 'replyTo.user:id,name']);

        return response()->json([
            'message' => $this->formatMessage($chat, (int) $request->user()->id),
        ], 201);
    }

    /**
     * Format satu pesan menjadi response array.
     */
    private function formatMessage(AdminChat $chat, int $currentUserId): array
    {
        $data = [
            'id'         => $chat->id,
            'user_id'    => $chat->user_id,
            'user_name'  => $chat->user?->name ?? 'Unknown',
            'message'    => $chat->message,
            'created_at' => $chat->created_at->format('H:i'),
            'date'       => $chat->created_at->format('d M Y'),
            'is_mine'    => $chat->user_id === $currentUserId,
            'reply_to'   => null,
        ];

        if ($chat->replyTo) {
            $data['reply_to'] = [
                'id'        => $chat->replyTo->id,
                'user_name' => $chat->replyTo->user?->name ?? 'Unknown',
                'message'   => $chat->replyTo->message,
            ];
        }

        return $data;
    }
}
