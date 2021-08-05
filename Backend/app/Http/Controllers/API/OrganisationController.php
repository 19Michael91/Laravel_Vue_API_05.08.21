<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\OrganisationRepositoryInterface;

class OrganisationController extends Controller
{
    /**
     * Takes an instance of OrganisationRepositoryInterface as a value
     *
     * @var OrganisationRepositoryInterface
     */
    private $organisationRepository;

    /**
     * Construct instance of OrganisationController.
     *
     * @param OrganisationRepositoryInterface $organisationRepository
     * @return void
     */
    public function __construct(OrganisationRepositoryInterface $organisationRepository)
    {
        $this->middleware('auth:api');

        $this->organisationRepository = $organisationRepository;
    }

    /**
     * Display a listing of the organisations.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->organisationRepository->index($request);
    }

    /**
     * Store a newly created organisation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->organisationRepository->store($request);
    }
}
