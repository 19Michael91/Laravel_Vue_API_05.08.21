<?php

namespace App\Repositories;

use App\Http\Resources\Organisation as OrganisationResource;
use App\Http\Resources\OrganisationCollection;
use App\Notifications\OrganisationCreatedNotification;
use App\Organisation;
use App\Repositories\Interfaces\OrganisationRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrganisationRepository implements OrganisationRepositoryInterface
{
    /**
     * Display a listing of the organisations.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $organisations = Organisation::all();

        if($request->has('subscribed')){
            $organisations = $organisations->where('subscribed', '=',true);
        }

        if($request->has('trial')){
            $organisations = $organisations->where('trial_end', '>=', Carbon::now()->toDateString());
        }

        return response(['success'   => true,
                        'message'    => 'Organizations by query',
                        'data'       => new OrganisationCollection($organisations->keyBy->id)], 200);
    }

    /**
     * Store a newly created organisation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name'          => 'required|max:255|unique:organisations',
            'description'   => 'max:255'
        ]);

        if($validator->fails()){
            return  response(['success'   => false,
                              'message'   => $validator->errors()], 400);

        }

        $data['user_id']  = auth()->id();
        $data['trial_end'] = Carbon::now()->addDays(30);

        $organisation = Organisation::create($data);

        auth()->user()->notify(new OrganisationCreatedNotification($organisation));

        return response(['success'   => true,
                        'message'    => 'Organisation created',
                        'data'       => new OrganisationResource($organisation)], 200);
    }
}
