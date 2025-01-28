<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Http\Resources\MessageResource;
use App\Services\MessageService;

class MessageController extends Controller
{
    public function __construct(private MessageService $messageService) {}

    public function getAll()
    {
        $messages = $this->messageService->getAll();
        return $this->successResponse(
            $this->resource($messages, MessageResource::class),
            'dataFetchedSuccessfully'
        );
    }

    public function find($messageId)
    {
        $message = $this->messageService->find($messageId);

        return $this->successResponse(
            $this->resource($message, MessageResource::class),
            'dataFetchedSuccessfully'
        );
    }

    public function sendMessage(MessageRequest $request)
    {
        // Store new chat message in the database (this would likely interact with a model or service to generate chatbot responses)
        $validatedData = $request->validated();

        $message = $this->messageService->sendMessage($validatedData);

        // Return to the chat page
        return response()->json([
            'message'  => $message->message,
            'response' => $message->response,
            'conversation_id' => $message->conversation_id,
        ]);
    }

    // public function create(MessageRequest $request)
    // {
    //     $validatedData = $request->validated();
    //     $message = $this->messageService->create($validatedData);

    //     return $this->successResponse(
    //         $this->resource($message, MessageResource::class),
    //         'dataAddedSuccessfully'
    //     );
    // }

    // public function update(MessageRequest $request, $messageId)
    // {
    //     $validatedData = $request->validated();
    //     $this->messageService->update($validatedData, $messageId);

    //     return $this->successResponse(
    //         null,
    //         'dataUpdatedSuccessfully'
    //     );
    // }

    public function delete($messageId)
    {
        $this->messageService->delete($messageId);

        return $this->successResponse(
            null,
            'dataDeletedSuccessfully'
        );
    }
}
