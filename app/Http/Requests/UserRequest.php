<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'register'   =>  $this->getRegisterRules(),
            'login'   =>  $this->getLoginRules(),
        };
    }

    public function getRegisterRules()
    {
        return [
            'name'     => 'string|nullable',
            'email'    => 'required|email',
            'password' => 'required|string|confirmed'
        ];
    }

    public function getLoginRules()
    {
        return [
            'email'    => 'required|email',
            'password' => 'required'
        ];
    }
}
