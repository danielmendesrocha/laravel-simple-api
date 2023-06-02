<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
        return [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string']
        ];
    }

    
    public function messages()
    {
        return [
            'name.required' => 'The users name is required',
            'email.required' => 'The users email is required',
            'password.required' => 'The password field is required',
            'email.email' => 'The users email is not a valid email',
            'email.unique' => 'The users email is already register'
        ];
    }
}
