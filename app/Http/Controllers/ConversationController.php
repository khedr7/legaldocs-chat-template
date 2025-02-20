<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConversationRequest;
use App\Http\Resources\ConversationResource;
use App\Models\Conversation;
use App\Services\ConversationService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;

class ConversationController extends Controller
{
    public function __construct(private ConversationService $conversationService) {}

    public function index(Request $request)
    {
        // Get all previous chats for the logged-in user
        $chats = Conversation::where('user_id', auth()->id())->orderBy('id', 'desc')->get();

        $groupedChats = $this->getGroupedChats($chats);

        // Return the chat view with the chats data
        return view('chats.chat', compact('groupedChats'));
    }

    public function show($conversation_id)
    {
        $chats = Conversation::where('user_id', auth()->id())->orderBy('id', 'desc')->get();

        $groupedChats = $this->getGroupedChats($chats);

        $chat = Conversation::where('id', $conversation_id)
            ->with('messages')
            ->first();


        // Return the chat view with the chats data
        return view('chats.chat', compact('groupedChats', 'chat', 'conversation_id'));
    }

    function getGroupedChats($chats)
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $last7Days = Carbon::today()->subDays(7);
        $last30Days = Carbon::today()->subDays(30);

        $groupedChats = [
            'Today' => [],
            'Yesterday' => [],
            'Previous 7 Days' => [],
            'Previous 30 Days' => [],
            'Older' => [],
        ];

        foreach ($chats as $ch) {
            $createdDate = Carbon::parse($ch->created_at);

            if ($createdDate->isToday()) {
                $groupedChats['Today'][] = $ch;
            } elseif ($createdDate->isYesterday()) {
                $groupedChats['Yesterday'][] = $ch;
            } elseif ($createdDate->greaterThanOrEqualTo($last7Days)) {
                $groupedChats['Previous 7 Days'][] = $ch;
            } elseif ($createdDate->greaterThanOrEqualTo($last30Days)) {
                $groupedChats['Previous 30 Days'][] = $ch;
            } else {
                $groupedChats['Older'][] = $ch;
            }
        }
        return $groupedChats;
    }
}
