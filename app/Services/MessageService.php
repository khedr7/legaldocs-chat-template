<?php

namespace App\Services;

use App\Models\Conversation;
use Illuminate\Support\Facades\DB;
use App\Traits\ModelHelper;
use App\Models\Message;
use App\Services\ConversationService;
use Illuminate\Support\Facades\Http;

class MessageService
{
    use ModelHelper;

    public function __construct(private ConversationService $conversationService) {}

    public function getAll()
    {
        return Message::all();
    }

    public function find($messageId)
    {
        return $this->findOrFail($messageId);
    }

    public function sendMessage($validatedData)
    {
        DB::beginTransaction();

        $chat_history = [];

        if (!isset($validatedData['conversation_id']) || $validatedData['conversation_id'] == null) {
            $conversation = $this->conversationService->create($validatedData);
            $validatedData['conversation_id'] = $conversation->id;
        }
        else{
            $conversation = Conversation::where('id', $validatedData['conversation_id'])->with('messages')->first();

            foreach ($conversation->messages as $message) {
                $chat_history[] = "أنت: {$message->message}";
                $chat_history[] = "روبوت الدردشة: {$message->response}";
            }
        }


        // Make the API call to get the AI response
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://chatbot-service-760395357156.us-central1.run.app/chat', [
            'user_message' => $validatedData['message'],
            'chat_history' => $chat_history,
        ]);

        // Extract the response from the API
        $aiResponse = $response->json()['response'];

        // Save the response in the validated data
        $validatedData['response'] = $aiResponse;

        $message = Message::create($validatedData);

        DB::commit();

        return $message;
    }

    public function create($validatedData)
    {
        DB::beginTransaction();

        $message = Message::create($validatedData);

        DB::commit();

        return $message;
    }

    public function update($validatedData, $messageId)
    {
        $message = $this->findOrFail($messageId);

        DB::beginTransaction();

        $message->update($validatedData);

        DB::commit();

        return true;
    }

    public function delete($messageId)
    {
        $message = $this->find($messageId);

        DB::beginTransaction();

        $message->delete();

        DB::commit();

        return true;
    }
}
