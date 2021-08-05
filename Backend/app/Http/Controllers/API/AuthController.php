<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Http\Resources\User as UserResource;

class AuthController extends Controller
{
    /**
     * Takes an instance of AuthRepositoryInterface as a value
     *
     * @var AuthRepositoryInterface
     */
    private $authRepository;

    /**
     * Construct instance of AuthController.
     *
     * @param AuthRepositoryInterface $authRepository
     * @return void
     */
    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * User authorization
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        return $this->authRepository->login($request);
    }
}
