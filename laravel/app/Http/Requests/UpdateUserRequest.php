<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        // get id from the route end point
        $userIdToBeIgnored = Route::current()->parameter('user');
        
        if($this->method() == 'PUT'){
            return [
                'name' => ['required'],
                'email' => ['required', 'email', "unique:users,email,$userIdToBeIgnored"], 
                'password' => ['required', 'string']
            ];
        } else {
            return [
                'name' => ['sometimes'],
                'email' => ['sometimes', 'email', "unique:users,email,$userIdToBeIgnored"], 
                'password' => ['sometimes', 'string']
            ];
        }
        
    }

    
    public function messages()
    {
        return [
            'email.email' => 'The users email is not a valid email',
            'email.unique' => 'The users email is already register',
            'name.required' => 'The users name is required',
            'email.required' => 'The users email is required',
            'password.required' => 'The password field is required',
            
        ];
    }
}
