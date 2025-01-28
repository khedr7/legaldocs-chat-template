<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

         return match ($this->route()->getActionMethod()) {
            'sendMessage'   =>  $this->getSendMessageRules(),
        };
    }

    public function getSendMessageRules()
    {
        return [
            'conversation_id' => 'nullable|exists:conversations,id',
            'message'         => 'required|string',
        ];
    }
}
