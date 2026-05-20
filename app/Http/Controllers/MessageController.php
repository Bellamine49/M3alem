<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\WorkerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'worker' && $user->workerProfile) {
            $conversations = Conversation::where('worker_profile_id', $user->workerProfile->id)
                ->with(['client', 'lastMessage'])
                ->orderByDesc('last_message_at')
                ->get();
        } else {
            $conversations = Conversation::where('client_id', $user->id)
                ->with(['workerProfile.user', 'lastMessage'])
                ->orderByDesc('last_message_at')
                ->get();
        }

        return view('messages.index', compact('conversations'));
    }

    public function show(Conversation $conversation)
    {
        $user = Auth::user();
        $isParticipant = $conversation->client_id === $user->id
            || ($user->workerProfile && $conversation->worker_profile_id === $user->workerProfile->id);

        abort_unless($isParticipant, 403);

        $messages = $conversation->messages()->with('sender')->orderBy('created_at')->get();
        $conversation->load(['workerProfile.user', 'client']);
        $messagesJson = $messages->map(fn($m) => ['id' => $m->id, 'body' => $m->body, 'sender_id' => $m->sender_id, 'time' => $m->created_at->format('H:i'), 'date' => $m->created_at->format('M j')]);

        return view('messages.show', compact('conversation', 'messages', 'messagesJson'));
    }

    public function store(Request $request, Conversation $conversation)
    {
        $user = Auth::user();
        $isParticipant = $conversation->client_id === $user->id
            || ($user->workerProfile && $conversation->worker_profile_id === $user->workerProfile->id);

        abort_unless($isParticipant, 403);

        $request->validate(['body' => 'required|string|max:2000']);

        $body = $request->body;

        $blockedPatterns = [
            // Phone numbers (various formats)
            '/(?:\+?\d{1,3}[\s\-\(\)]?)?\d[\d\s\-\(\)]{6,}\d/',
            // WhatsApp - specific enough to avoid false positives
            '/whatsapp/i',
            '/whats\s*app/i',
            '/wa\.me/i',
            '/wa\.link/i',
            // Telegram - specific enough
            '/telegram/i',
            '/t\.me\//i',
            // Instagram - specific enough
            '/instagram/i',
            // Facebook - specific enough
            '/facebook\.com/i',
            '/fb\.me/i',
            // Email addresses
            '/[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}/i',
            // "Call me" / "Contact me" phrases
            '/call\s*me/i',
            '/contact\s*me/i',
            '/my\s*phone\s*(?:is|number)?/i',
            '/my\s*number\s*is/i',
            '/send\s*me\s*(?:your\s*)?(?:phone|number)/i',
        ];

        foreach ($blockedPatterns as $pattern) {
            if (preg_match($pattern, $body)) {
                return back()->withErrors(['body' => 'Your message contains restricted content. Please keep all communication on-platform for safety.']);
            }
        }

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'body' => $body,
        ]);

        $conversation->update(['last_message_at' => now()]);

        return back()->with('success', 'Message sent!');
    }

    public function start(Request $request, WorkerProfile $worker)
    {
        $user = Auth::user();

        $conversation = Conversation::firstOrCreate(
            [
                'client_id' => $user->id,
                'worker_profile_id' => $worker->id,
            ],
            ['last_message_at' => now()]
        );

        if ($request->filled('body')) {
            $request->validate(['body' => 'required|string|max:2000']);

            Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => $user->id,
                'body' => $request->body,
            ]);
        }

        return redirect()->route('messages.show', $conversation);
    }
}
