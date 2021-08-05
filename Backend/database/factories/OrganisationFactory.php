<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Organisation;
use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Organisation::class, function (Faker $faker) {
    return [
        'name'          => $faker->company,
        'description'   => $faker->sentence,
        'subscribed'    => rand(0, 1),
        'user_id'       => function(){
                               return factory(User::class)->create()->id;
                           },
        'trial_end'     => Carbon::now()->addDays(30)
    ];
});
