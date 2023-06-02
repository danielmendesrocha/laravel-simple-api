<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginApi(Request $request){
        
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
     

        // check if user exist
        if (Auth::attempt($credentials)){ // attempt already compares the hashed password with the string
            
            //get an instance of that user
            $user = User::where('email', $credentials['email'])->first();

            //create user token
            $token = $user->createToken('apptoken')->plainTextToken;

            // remove token id from the string
            $tokenValue = explode('|', $token, 2)[1];
            
            // return response()->json(["success" => true, "token" => $tokenValue])->setStatusCode(200);
            return response()->success($tokenValue);
        }

        // return response()->json(["success" => false, "data" => "Wrong credentials or user not found"])->setStatusCode(200);
        return response()->error('Wrong credentials or user not found');

    }
}
