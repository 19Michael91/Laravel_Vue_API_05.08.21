<?php

namespace App\Observers;

use App\Organisation;
use Carbon\Carbon;

class OrganisationObserver
{
    /**
     * Handle the organisation "creating" event.
     *
     * @param  \App\Organisation  $organisation
     * @return void
     */
    public function creating(Organisation $organisation)
    {
        $organisation->user_id      = auth()->id();
        $organisation->trial_end    = Carbon::now()->addDays(30);
    }
}
