<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface OrganisationRepositoryInterface
{
    /**
     * Display a listing of the organisations.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request);

    /**
     * Store a newly created organisation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request);
}
