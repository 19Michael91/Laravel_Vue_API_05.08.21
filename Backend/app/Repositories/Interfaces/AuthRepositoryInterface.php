<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface AuthRepositoryInterface
{
    /**
     * User authorization
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request);
}
