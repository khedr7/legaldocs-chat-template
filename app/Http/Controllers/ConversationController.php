<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConversationRequest;
use App\Http\Resources\ConversationResource;
use App\Models\Conversation;
use App\Services\ConversationService;
use Illuminate\Support\Facades\Request;

class ConversationController extends Controller
{
    public function __construct(private ConversationService $conversationService) {}

    public function index(Request $request)
    {
        // Get all previous chats for the logged-in user
        $chats = Conversation::where('user_id', auth()->id())->orderBy('id', 'desc')->get();

        // Return the chat view with the chats data
        return view('chats.chat', compact('chats'));
    }

    public function show($conversation_id)
    {
        $chats = Conversation::where('user_id', auth()->id())->orderBy('id', 'desc')->get();

        // Get all previous chats for the logged-in user
        $chat = Conversation::where('id', $conversation_id)
            ->with('messages')
            ->first();


        // Return the chat view with the chats data
        return view('chats.chat', compact('chats', 'chat', 'conversation_id'));
    }
}
