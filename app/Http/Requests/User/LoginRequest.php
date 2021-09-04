<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required_without_all:name|email',
            'name' => 'required_without_all:email|string',
            'password' => 'required|string|min:6',
        ];
    }
}
