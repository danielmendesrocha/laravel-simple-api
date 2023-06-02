<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Database\QueryException;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return response()->success(User::All());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {


        try {

            $incomingFields = $request->validated();
            $incomingFields['password'] = Hash::make($incomingFields['password']);
            $user = User::create($incomingFields);

            return response()->success($user);
        } catch (QueryException $exception) {
            $errorMessage = $exception->getMessage();
            return response()->error($errorMessage);
        }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id); 

        if($user) {
            return response()->success($user);
        } else {
            return response()->error("User not Found")->setStatusCode(404);

        }
        
        
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {

        $user = User::find($id);
        
        if($user) { 
       
            try {
                $incomingFields = $request->validated();

                if(isset($incomingFields['password'])){
                    $incomingFields['password'] = Hash::make($incomingFields['password']);
                }
                
                $user->update($incomingFields);
                return response()->success($user);
                
            } catch (QueryException $exception) {
                $errorMessage = $exception->getMessage();
                return response()->error($errorMessage);
            }

        } else {
            return response()->error('No User found with the id ' . $id);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      
        $user = User::find($id);
        
        if($user) { 
       
            $user->delete();
            return response()->success('');
        } else {
            return response()->error('No User found with the id ' . $id);
        }
    }
}
