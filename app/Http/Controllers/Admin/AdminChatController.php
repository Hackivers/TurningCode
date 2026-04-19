<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminChat;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdminChatController extends Controller
{
    /**
     * Ambil pesan chat. Mendukung polling via ?after=<id>.
     * Sekaligus melacak status online admin.
     */
    public function index(Request $request): JsonResponse
    {
        $currentUserId = (int) $request->user()->id;

        // Tandai user saat ini sebagai online selama 1 menit ke depan
        Cache::put('admin_online_' . $currentUserId, true, now()->addMinutes(1));

        $query = AdminChat::with(['user:id,name,email', 'replyTo.user:id,name']);

        if ($request->filled('after')) {
            $messages = $query->where('id', '>', (int) $request->input('after'))
                              ->orderBy('id', 'asc')
                              ->get();
        } else {
            $messages = $query->latest()->limit(50)->get()->reverse()->values();
        }

        // Cari siapa saja admin yang sedang online
        $admins = User::where('role', 'admin')->get();
        $onlineAdmins = [];
        foreach ($admins as $admin) {
            if (Cache::has('admin_online_' . $admin->id)) {
                $onlineAdmins[] = [
                    'id' => $admin->id,
                    'name' => explode('@', $admin->email)[0],
                    'avatar' => $admin->avatar ? asset('storage/' . $admin->avatar) : null,
                    'is_it_me' => $admin->id === $currentUserId
                ];
            }
        }

        return response()->json([
            'messages' => $messages->map(fn (AdminChat $chat) => $this->formatMessage($chat, $currentUserId)),
            'online_admins' => $onlineAdmins,
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
            'user_name'  => $chat->user ? explode('@', $chat->user->email)[0] : 'Unknown',
            'message'    => $chat->message,
            'created_at' => $chat->created_at->format('H:i'),
            'date'       => $chat->created_at->format('d M Y'),
            'is_mine'    => $chat->user_id === $currentUserId,
            'reply_to'   => null,
        ];

        if ($chat->replyTo) {
            $data['reply_to'] = [
                'id'        => $chat->replyTo->id,
                'user_name' => $chat->replyTo->user ? explode('@', $chat->replyTo->user->email)[0] : 'Unknown',
                'message'   => $chat->replyTo->message,
            ];
        }

        return $data;
    }
}
