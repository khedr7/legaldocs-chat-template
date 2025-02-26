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

    // public function find($messageId)
    // {
    //     return $this->findOrFail($messageId);
    // }


    // {{{{old version}}}}

    // public function sendMessage($validatedData)
    // {
    //     DB::beginTransaction();

    //     $chat_history = [];

    //     if (!isset($validatedData['conversation_id']) || $validatedData['conversation_id'] == null) {
    //         $conversation = $this->conversationService->create($validatedData);
    //         $validatedData['conversation_id'] = $conversation->id;
    //     } else {
    //         $conversation = Conversation::where('id', $validatedData['conversation_id'])->with('messages')->first();

    //         foreach ($conversation->messages as $message) {
    //             $chat_history[] = "أنت: {$message->message}";
    //             $chat_history[] = "روبوت الدردشة: {$message->response}";
    //         }
    //     }


    //     // Make the API call to get the AI response
    //     $response = Http::withHeaders([
    //         'Content-Type' => 'application/json',
    //     ])->post('https://chatbot-service-760395357156.us-central1.run.app/chat', [
    //         'user_message' => $validatedData['message'],
    //         'chat_history' => $chat_history,
    //     ]);

    //     // Extract the response from the API
    //     $aiResponse = $response->json()['response'];

    //     // Save the response in the validated data
    //     $validatedData['response'] = $aiResponse;

    //     $message = Message::create($validatedData);

    //     DB::commit();

    //     return $message;
    // }

    // {{ new version with files }}
    public function sendMessage($validatedData)
    {
        DB::beginTransaction();

        // Build chat history as an array of history objects
        $chat_history = [];

        // If no conversation exists, create a new one
        if (!isset($validatedData['conversation_id']) || $validatedData['conversation_id'] == null) {
            $conversation = $this->conversationService->create($validatedData);
            $validatedData['conversation_id'] = $conversation->id;
        } else {
            // Load conversation with its messages and related documents
            $conversation = Conversation::where('id', $validatedData['conversation_id'])
                ->with(['messages.messageDocuments']) // assuming you set up the relationship as "messageDocuments"
                ->first();

            // Iterate over messages to build chat history
            foreach ($conversation->messages as $message) {
                // Add the user's message with any attached documents
                $chat_history[] = [
                    'role'       => 'user',
                    'message'    => $message->message,
                    'document' => optional($message->messageDocuments)->pluck('title')->toArray() ?? []
                ];
                // Add the model's (AI) response, with no documents attached
                $chat_history[] = [
                    'role'       => 'model',
                    'message'    => $message->response,
                    'document' => [] // model response has no documents associated in history
                ];
            }
        }

        // Prepare the API payload:
        // The new user message is sent as the "user_message"
        // and the history is passed as "chat_history"
        $apiPayload = [
            'user_message' => $validatedData['message'],
            'chat_history' => $chat_history,
        ];

        // Make the API call to get the AI response and document list
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://chatbot-api-760395357156.us-central1.run.app/chat', $apiPayload);

        $responseData = $response->json();

        // Extract the response text and document list from the API response
        $aiResponse = $responseData['model_message'] ?? null;
        $documentList = $responseData['document'] ?? [];

        // Save the response in the validated data
        $validatedData['response'] = $aiResponse;

        // Create the message record in the database
        $message = Message::create($validatedData);

        // If documents were returned, create records in the message_documents table
        if (!empty($documentList)) {
            foreach ($documentList as $docName) {
                $message->messageDocuments()->create([
                    'title' => $docName,
                ]);
            }
        }

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

    // public function update($validatedData, $messageId)
    // {
    //     $message = $this->findOrFail($messageId);

    //     DB::beginTransaction();

    //     $message->update($validatedData);

    //     DB::commit();

    //     return true;
    // }

    // public function delete($messageId)
    // {
    //     $message = $this->find($messageId);

    //     DB::beginTransaction();

    //     $message->delete();

    //     DB::commit();

    //     return true;
    // }
}
