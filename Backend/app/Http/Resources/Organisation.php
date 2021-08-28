<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User as UserResource;

class Organisation extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'description'   => $this->description,
            'user'          => new UserResource($this->user),
            'trial_end'     => $this->trial_end,
            'subscribed'    => $this->subscribed,
            'created_at'    => $this->created_at,
        ];
    }
}
