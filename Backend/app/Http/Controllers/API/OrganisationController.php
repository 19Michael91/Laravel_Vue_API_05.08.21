<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Organisation;
use Carbon\Carbon;
use App\Http\Resources\OrganisationCollection;
use App\Http\Resources\Organisation as OrganisationResource;
use Illuminate\Support\Facades\Validator;
use App\Notifications\OrganisationCreatedNotification;

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
            'name'          => 'required|min:2|max:64|unique:organisations',
            'description'   => 'required|min:4|max:255'
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
