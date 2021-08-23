<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Http\Resources\User as UserResource;

class AuthController extends Controller
{

    /**
     * User Registration
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'email|required|unique:users',
            'name'      => 'required|min:5|max:16|unique:users',
            'password'  => 'required|min:8|max:16'
        ]);

        if($validator->fails()){
            return  response(['success'   => false,
                              'message'   => $validator->errors()], 400);
        }

        $registerData = ['email'       => $request->get('email'),
                         'name'        => $request->get('name'),
                         'password'    => bcrypt($request->get('password'))];

        User::create($registerData);

        auth()->attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);

        auth()->user()->access_token = auth()->user()->createToken('authToken')->accessToken;

        return response(['success'   => true,
                         'message'   => 'User created',
                         'data'      => new UserResource(auth()->user())], 200);
    }

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
