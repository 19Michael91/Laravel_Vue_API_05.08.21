<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Http\Resources\User as UserResource;
use App\Http\Requests\AuthRegistrationRequest;
use App\Http\Requests\AuthLoginRequest;

class AuthController extends Controller
{

    /**
     * User Registration
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function register(AuthRegistrationRequest $request)
    {
        User::create($request->all());

        auth()->attempt(['email'    => $request->email,
                         'password' => $request->password]);

        auth()->user()->access_token = auth()->user()
                                             ->createToken('authToken')
                                             ->accessToken;

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
    public function login(AuthLoginRequest $request)
    {
        if (!auth()->attempt($request->all())) {
            return  response(['success'   => false,
                              'message'   => ['credentials' => ['Invalid Credentials']]], 400);
        }

        auth()->user()->access_token = auth()->user()
                                             ->createToken('authToken')
                                             ->accessToken;

        return response(['success'   => true,
                         'message'   => 'User login',
                         'data'      => new UserResource(auth()->user())], 200);
    }
}
