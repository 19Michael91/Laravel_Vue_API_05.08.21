<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Organisation;
use Carbon\Carbon;
use App\Http\Resources\OrganisationCollection;
use App\Http\Resources\Organisation as OrganisationResource;
use App\Notifications\OrganisationCreatedNotification;
use App\Http\Requests\OrganisationStoreRequest;
use App\Http\Requests\OrganisationUpdateRequest;

class OrganisationController extends Controller
{
    /**
     * Construct instance of OrganisationController.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the organisations.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $organisations = auth()->user()->organisations;

        if($request->has('subscribed')){
            $organisations = $organisations->where('subscribed', '=',true);
        }

        if($request->has('trial')){
            $organisations = $organisations->where('trial_end', '>=', Carbon::now()->toDateString());
        }

        return response(['success'   => true,
                         'message'   => 'Organizations by query',
                         'data'      => new OrganisationCollection($organisations->keyBy->id)], 200);
    }

    /**
     * Store a newly created organisation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrganisationStoreRequest $request)
    {
        $organisation = Organisation::create($request->all());

        auth()->user()->notify(new OrganisationCreatedNotification($organisation));

        return response(['success'   => true,
                         'message'   => 'Organisation created',
                         'data'      => new OrganisationResource($organisation)], 200);
    }

    /**
     * Update organisation.
     *
     * @param \App\Organisation $organisation
     * @param  App\Http\Requests\OrganisationUpdateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Organisation $organisation, OrganisationUpdateRequest $request)
    {
        $this->authorize('update', $organisation);

        $organisation->update($request->all());

        return response(['success'   => true,
                         'message'   => 'Organizations updated'], 200);
    }

    /**
     * Delete organisation.
     *
     * @param \App\Organisation $organisation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organisation $organisation)
    {
        $this->authorize('delete', $organisation);

        $organisation->delete();

        return response(['success'   => true,
                         'message'   => 'Organizations deleted'], 200);
    }
}
