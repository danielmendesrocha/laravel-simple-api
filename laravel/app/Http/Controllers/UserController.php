<?php

namespace App\Http\Controllers;


use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{

    /**
     * Returns all users
     */
    public function getAll(){
        return response()->json(User::all())->setStatusCode(200);
    }

    /**
     * Returns single user
     */
    public function getSingle(Request $request, $id){
        
        $user = User::find($id);

        if(!$user) return response()->json(["success" => false, "data" => "User not found"])->setStatusCode(404);

        return response()->json($user)->setStatusCode(200);
    }

    /**
     * Creates user
     */
    public function create(Request $request){

        // rules for validation
        $inputRules = [
            'name' => 'required',
            'email' => ['required', 'email'],
            'password' => ['required', Password::min(6)]
        ];

        // validates input
        $validatedData = $this->validateData($request, $inputRules);

        // if data has errors return response
        if($validatedData instanceOf JsonResponse) return $validatedData;

        // insert on database
        $createdRow = User::create($validatedData);

        return response(["success" => true, "data" => $createdRow], 201);

    }

    /**
     * Updates user
     */
    public function update(Request $request, $id){
        
        // searchs for user
        $user = User::find($id);

        if(!$user) return response()->json(["success" => false, "data" => "User not found"])->setStatusCode(404);

        // rules for validation
        $inputRules = [
            'name' => '',
            'email' => 'email',
            'password' => [Password::min(6)]
        ];

        // validates input
        $validatedData = $this->validateData($request, $inputRules);

        
        // if data has errors return response
        if($validatedData instanceOf JsonResponse) return $validatedData;
   
        // updates with the validated data
        $user->update($validatedData);

        return response()->json(["success" => true, "data" => $user])->setStatusCode(201) ;

    }

    /**
     * Deletes user
     */
    public function delete(Request $request, $id){

        $user = User::find($id);

        if(!$user) return response()->json(["success" => false, "data" => "User not found"])->setStatusCode(404);

        $user->delete();

        return response()->json(["success" => true]);
    }

    /**
     * Generates access token
     */
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
            
            return response()->json(["success" => true, "token" => $tokenValue])->setStatusCode(200);
        }

        return response()->json(["success" => false, "data" => "Wrong credentials or user not found"])->setStatusCode(200);

    }

    /**
     * Function to validate inputs when creating or updating a user
     */
    private function validateData(Request $request, array $rules){

        // validate input
        $validator = Validator::make($request->all(), $rules);

        // return response if validation failed
        if ($validator->fails()) {
            return response()->json(["success" => false, "errors" => $validator->errors()])->setStatusCode(400) ;
        }

        // get validated input
        $validatedData = $validator->validated();

        // remove any tags and hashs password
        foreach ($validatedData as $key => $value ) {

            // hash password and continue to the next iteration
            if($key === 'password'){
                $validatedData[$key] =  Hash::make($value);
                continue;
            } 

            $validatedData[$key] = strip_tags($value);
        }

        return $validatedData;
    }
}