<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Traits\ModelHelper;
use App\Models\Conversation;

class ConversationService
{
    use ModelHelper;

    public function getAll()
    {
        return Conversation::where('user_id', auth()->id())->get();
    }

    public function find($conversationId)
    {
        return $this->findOrFail($conversationId);
    }

    public function create($validatedData)
    {
        DB::beginTransaction();
        $validatedData['title'] = $validatedData['message'];
        $validatedData['user_id'] = auth()->user()->id;

        $conversation = Conversation::create($validatedData);

        DB::commit();

        return $conversation;
    }

    public function update($validatedData, $conversationId)
    {
        $conversation = $this->findOrFail($conversationId);

        DB::beginTransaction();

        $conversation->update($validatedData);

        DB::commit();

        return true;
    }

    public function delete($conversationId)
    {
        $conversation = $this->find($conversationId);

        DB::beginTransaction();

        $conversation->delete();

        DB::commit();

        return true;
    }
}
