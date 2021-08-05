<?php

namespace App\Repositories;

use App\Http\Resources\User as UserResource;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthRepository implements AuthRepositoryInterface
{
    /**
     * User authorization
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $loginData = $request->all();

        $validator = Validator::make($loginData, [
            'email'     => 'email|required',
            'password'  => 'required'
        ]);

        if($validator->fails()){
            return  response(['success'   => false,
                              'message'   => $validator->errors()], 400);
        }

        if($validator->fails()){
            return  response(['success'   => false,
                              'message'   => $request->errors()], 400);
        }

        if (!auth()->attempt($loginData)) {
            return  response(['success'   => false,
                              'message'   => ['credentials' => ['Invalid Credentials']]], 400);
        }

        auth()->user()->access_token = auth()->user()->createToken('authToken')->accessToken;

        return response(['success'   => true,
                         'message'   => 'User login',
                         'data'      => new UserResource(auth()->user())], 200);
    }
}
